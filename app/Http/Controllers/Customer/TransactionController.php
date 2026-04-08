<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Tampilkan halaman checkout.
     */
    public function checkout()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')
                ->with('error', 'Keranjang belanja masih kosong');
        }

        // Cek stok semua item
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart')
                    ->with('error', "Stok {$item->product->name} tidak mencukupi. Tersedia: {$item->product->stock}");
            }
        }

        $defaultAddress = Address::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->latest()
            ->first();

        if (!$defaultAddress) {
            return redirect()->route('addresses.index')
                ->with('error', 'Silakan tambah alamat terlebih dahulu.');
        }

        $shippingAddress = $defaultAddress->formatted_address;

        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingCost = 10000; // Bisa diatur dinamis
        $total = $subtotal + $shippingCost;

        return view('customer.transaction.checkout', compact(
            'cartItems',
            'subtotal',
            'shippingCost',
            'total',
            'defaultAddress',
            'shippingAddress'
        ));
    }

    /**
     * Proses checkout (buat transaksi baru).
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_courier' => 'required|string',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang belanja kosong');
        }

        // Cek stok sekali lagi
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Stok {$item->product->name} tidak mencukupi");
            }
        }

        DB::beginTransaction();

        try {
            // Hitung total
            $subtotal = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });
            
            $shippingCost = 10000; // Bisa diatur dinamis
            $total = $subtotal + $shippingCost;

            // Buat invoice code unik
            $invoiceCode = Transaction::generateInvoiceCode();

            // Buat transaksi
            $transaction = Transaction::create([
                'invoice_code' => $invoiceCode,
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'shipping_address' => $request->shipping_address,
                'shipping_courier' => $request->shipping_courier,
                'notes' => $request->notes,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'shipping_status' => 'packing'
            ]);

            // Buat detail transaksi dan kurangi stok
            foreach ($cartItems as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price_at_time' => $item->product->price,
                    'subtotal' => $item->product->price * $item->quantity
                ]);

                // Kurangi stok produk
                $item->product->decrement('stock', $item->quantity);
            }

            // Hapus keranjang
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('payments.show', $transaction->id)
                ->with('success', 'Checkout berhasil! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan daftar transaksi user.
     */
    public function index(Request $request)
    {
        $query = Transaction::with('details.product', 'latestPayment', 'shipping')
            ->where('user_id', Auth::id());

        $status = $request->get('status');
        if ($status && in_array($status, ['completed', 'cancelled', 'pending', 'processing'])) {
            $query->where('status', $status);
        }

        $transactions = $query->latest()->paginate(10)->withQueryString();

        return view('customer.transaction.index', compact('transactions', 'status'));
    }

    /**
     * Tampilkan detail transaksi.
     */
    public function show(Transaction $transaction)
    {
        // Pastikan transaksi milik user yang login
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        return redirect()->route('orders')
            ->with('success', 'Pembayaran sedang diproses. Silakan cek di daftar pesanan.');
    }

    /**
     * Halaman pembayaran QRIS.
     */
    public function payment(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->load('details.product');

        $itemsCount = $transaction->details->sum('quantity');
        $subtotal = $transaction->subtotal ?? 0;
        $shippingCost = $transaction->shipping_cost ?? 0;
        $total = $transaction->total_amount ?? 0;

        return view('customer.payment.qris', compact(
            'transaction',
            'itemsCount',
            'subtotal',
            'shippingCost',
            'total'
        ));
    }

    /**
     * Batalkan transaksi.
     */
    public function cancel(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya bisa cancel jika status pending
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi tidak dapat dibatalkan');
        }

        DB::beginTransaction();

        try {
            // Kembalikan stok
            foreach ($transaction->details as $detail) {
                $detail->product->increment('stock', $detail->quantity);
            }

            $transaction->update([
                'status' => 'cancelled',
                'payment_status' => 'failed'
            ]);

            DB::commit();

            return back()->with('success', 'Transaksi berhasil dibatalkan');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan');
        }
    }

    /**
     * Konfirmasi penerimaan barang.
     */
    public function confirmReceived(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transaction->shipping_status !== 'shipped') {
            return back()->with('error', 'Barang belum dikirim');
        }

        $transaction->update([
            'shipping_status' => 'delivered',
            'status' => 'completed'
        ]);

        return back()->with('success', 'Terima kasih! Barang telah diterima.');
    }

    /**
     * API: Get riwayat transaksi untuk mobile.
     */
    public function apiIndex()
    {
        $transactions = Transaction::with('details.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }
}
