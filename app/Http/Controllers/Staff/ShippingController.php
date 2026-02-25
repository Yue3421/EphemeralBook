<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Shipping;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    /**
     * Daftar transaksi yang perlu diproses pengirimannya.
     */
    public function index()
    {
        $transactions = Transaction::with('user', 'details.product')
            ->whereIn('shipping_status', ['packing', 'shipped'])
            ->where('payment_status', 'paid')
            ->latest()
            ->paginate(15);

        return view('staff.shipping.index', compact('transactions'));
    }

    /**
     * Proses pengiriman (packing).
     */
    public function process(Transaction $transaction)
    {
        // Validasi status
        if ($transaction->payment_status !== 'paid') {
            return back()->with('error', 'Pembayaran belum dikonfirmasi');
        }

        if ($transaction->shipping_status !== 'packing') {
            return back()->with('error', 'Status pengiriman tidak valid');
        }

        return view('staff.shipping.process', compact('transaction'));
    }

    /**
     * Update status menjadi shipped (dikirim).
     */
    public function ship(Request $request, Transaction $transaction)
    {
        $request->validate([
            'courier' => 'required|string',
            'tracking_number' => 'required|string',
            'shipping_date' => 'required|date'
        ]);

        // Cek apakah sudah ada data shipping
        $shipping = $transaction->shipping ?? new Shipping();

        $shipping->fill([
            'transaction_id' => $transaction->id,
            'courier' => $request->courier,
            'tracking_number' => $request->tracking_number,
            'shipped_by' => Auth::id(),
            'shipped_at' => $request->shipping_date
        ]);

        $shipping->save();

        // Update transaksi
        $transaction->update([
            'shipping_status' => 'shipped',
            'status' => 'processing'
        ]);

        return redirect()->route('staff.shipping.index')
            ->with('success', 'Status pengiriman berhasil diupdate');
    }

    /**
     * Tandai sebagai delivered (diterima) - manual jika perlu.
     */
    public function markDelivered(Transaction $transaction)
    {
        if ($transaction->shipping_status !== 'shipped') {
            return back()->with('error', 'Barang belum dikirim');
        }

        $transaction->update([
            'shipping_status' => 'delivered',
            'status' => 'completed'
        ]);

        if ($transaction->shipping) {
            $transaction->shipping->update([
                'delivered_at' => now()
            ]);
        }

        return back()->with('success', 'Barang ditandai telah diterima');
    }

    /**
     * Tracking pengiriman (untuk customer).
     */
    public function track($invoiceCode)
    {
        $transaction = Transaction::with('shipping', 'details.product')
            ->where('invoice_code', $invoiceCode)
            ->firstOrFail();

        return view('customer.shipping.track', compact('transaction'));
    }

    /**
     * API Tracking.
     */
    public function apiTrack($invoiceCode)
    {
        $transaction = Transaction::with('shipping')
            ->where('invoice_code', $invoiceCode)
            ->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'invoice_code' => $transaction->invoice_code,
                'shipping_status' => $transaction->shipping_status,
                'courier' => $transaction->shipping->courier ?? null,
                'tracking_number' => $transaction->shipping->tracking_number ?? null,
                'shipped_at' => $transaction->shipping->shipped_at ?? null,
                'delivered_at' => $transaction->shipping->delivered_at ?? null,
                'estimated_arrival' => $transaction->shipping->shipped_at ? 
                    date('Y-m-d', strtotime($transaction->shipping->shipped_at . ' +3 days')) : null
            ]
        ]);
    }
}