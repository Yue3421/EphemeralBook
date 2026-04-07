<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Laporan penjualan.
     */
    public function sales(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'period' => 'nullable|in:day,week,month,year'
        ]);

        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        // Data penjualan per periode
        $salesData = Transaction::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('payment_status', 'paid')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Total keseluruhan
        $summary = [
            'total_transactions' => $salesData->sum('total_transactions'),
            'total_revenue' => $salesData->sum('total_revenue'),
            'average_transaction' => $salesData->count() > 0 ? $salesData->avg('total_revenue') : 0,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        // Produk terlaris
        $topProducts = DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->whereBetween('transactions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('transactions.payment_status', 'paid')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(transaction_details.quantity) as total_sold'),
                DB::raw('SUM(transaction_details.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $monthlySales = Transaction::whereYear('created_at', now()->year)
            ->where('payment_status', 'paid')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total_revenue', 'month');

        $totalStaff = User::where('role', 'staff')->count();
        $totalUsers = User::where('role', 'customer')->count();
        $totalOrders = Transaction::count();

        if ($request->wantsJson()) {
            return response()->json([
                'summary' => $summary,
                'sales_data' => $salesData,
                'top_products' => $topProducts,
                'monthly_sales' => $monthlySales,
                'total_staff' => $totalStaff,
                'total_users' => $totalUsers,
                'total_orders' => $totalOrders
            ]);
        }

        return view('admin.reports.sales', compact(
            'salesData',
            'summary',
            'topProducts',
            'monthlySales',
            'totalStaff',
            'totalUsers',
            'totalOrders'
        ));
    }

    /**
     * Laporan stok.
     */
    public function stock(Request $request)
    {
        $query = Product::query();

        // Filter stok
        if ($request->has('status')) {
            if ($request->status === 'low') {
                $query->where('stock', '<', 10);
            } elseif ($request->status === 'out') {
                $query->where('stock', 0);
            } elseif ($request->status === 'available') {
                $query->where('stock', '>', 0);
            }
        }

        // Pencarian
        if ($request->has('search')) {
            $search = '%' . $request->search . '%';
            $query->where('name', 'like', $search);
        }

        $products = $query->orderBy('stock')->paginate(20);

        $summary = [
            'total_products' => Product::count(),
            'total_stock' => Product::sum('stock'),
            'low_stock' => Product::where('stock', '<', 10)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'total_value' => Product::sum(DB::raw('price * stock'))
        ];

        return view('admin.reports.stock', compact('products', 'summary'));
    }

    /**
     * Laporan transaksi.
     */
    public function transactions(Request $request)
    {
        $query = Transaction::with('user');

        // Filter tanggal
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->input('status'));
        }

        // Filter payment status
        if ($request->has('payment_status') && $request->payment_status != 'all') {
            $query->where('payment_status', $request->input('payment_status'));
        }

        $transactions = $query->latest()->paginate(20);

        // Statistik
        $statistics = [
            'total' => Transaction::count(),
            'paid' => Transaction::where('payment_status', 'paid')->count(),
            'pending' => Transaction::where('payment_status', 'pending')->count(),
            'revenue' => Transaction::where('payment_status', 'paid')->sum('total_amount')
        ];

        return view('admin.reports.transactions', compact('transactions', 'statistics'));
    }

    /**
     * Export laporan ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $type = $request->type ?? 'sales';
        
        if ($type === 'sales') {
            return $this->exportSalesPdf($request);
        } elseif ($type === 'stock') {
            return $this->exportStockPdf();
        } else {
            return $this->exportTransactionsPdf($request);
        }
    }

    /**
     * Export PDF Laporan Penjualan
     */
    private function exportSalesPdf($request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        // Data penjualan
        $salesData = Transaction::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('payment_status', 'paid')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Summary
        $summary = [
            'total_transactions' => $salesData->sum('total_transactions'),
            'total_revenue' => $salesData->sum('total_revenue'),
            'average_transaction' => $salesData->count() > 0 ? $salesData->avg('total_revenue') : 0,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        // Produk terlaris
        $topProducts = DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->whereBetween('transactions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('transactions.payment_status', 'paid')
            ->select(
                'products.name',
                DB::raw('SUM(transaction_details.quantity) as total_sold'),
                DB::raw('SUM(transaction_details.subtotal) as total_revenue')
            )
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $data = [
            'title' => 'Laporan Penjualan',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'salesData' => $salesData,
            'summary' => $summary,
            'topProducts' => $topProducts,
            'generated_at' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.sales', $data);
        return $pdf->download('laporan-penjualan-' . $startDate . '-sampai-' . $endDate . '.pdf');
    }

    /**
     * Export PDF Laporan Stok
     */
    private function exportStockPdf()
    {
        $products = Product::orderBy('stock')->get();

        $summary = [
            'total_products' => Product::count(),
            'total_stock' => Product::sum('stock'),
            'low_stock' => Product::where('stock', '<', 10)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'total_value' => Product::sum(DB::raw('price * stock'))
        ];

        $data = [
            'title' => 'Laporan Stok Produk',
            'products' => $products,
            'summary' => $summary,
            'generated_at' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.stock', $data);
        return $pdf->download('laporan-stok-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export PDF Laporan Transaksi
     */
    private function exportTransactionsPdf($request)
    {
        $query = Transaction::with('user');

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
            $startDate = $request->start_date;
        } else {
            $startDate = 'Semua';
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
            $endDate = $request->end_date;
        } else {
            $endDate = 'Semua';
        }

        $transactions = $query->latest()->get();

        $statistics = [
            'total' => $transactions->count(),
            'paid' => $transactions->where('payment_status', 'paid')->count(),
            'pending' => $transactions->where('payment_status', 'pending')->count(),
            'revenue' => $transactions->where('payment_status', 'paid')->sum('total_amount')
        ];

        $data = [
            'title' => 'Laporan Transaksi',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'transactions' => $transactions,
            'statistics' => $statistics,
            'generated_at' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.transactions', $data);
        return $pdf->download('laporan-transaksi-' . date('Y-m-d') . '.pdf');
    }
}
