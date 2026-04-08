<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard customer - hanya untuk yang sudah login.
     */
    public function customerDashboard()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Statistik customer
        $totalOrders = Transaction::where('user_id', $user->id)->count();
        $pendingOrders = Transaction::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $completedOrders = Transaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $totalSpent = Transaction::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
        
        // Total buku yang sudah dibeli
        $totalBooksBought = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.user_id', $user->id)
            ->sum('transaction_details.quantity');

        // Produk untuk ditampilkan
        $products = Product::where('stock', '>', 0)->latest()->get();
        return view('customer.dashboard', compact('products'));

        // 5 transaksi terbaru
        $recentOrders = Transaction::with('details.product')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('customer.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalSpent',
            'totalBooksBought',
            'products',
            'recentOrders'
        ));
    }

    /**
     * Method index untuk redirect
     */
    public function index()
    {
        if (Auth::check()) {
            // Redirect berdasarkan role
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'staff') {
                return redirect()->route('staff.dashboard');
            } else {
                return redirect()->route('customer.dashboard');
            }
        }
        
        return redirect()->route('login');
    }
}
