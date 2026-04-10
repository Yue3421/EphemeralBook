<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = Transaction::with('details.product')
            ->latest();

        if ($status && in_array($status, ['completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        $transactions = $query->paginate(10)->withQueryString();

        $totalOrders = Transaction::count();
        $completedOrders = Transaction::where('status', 'completed')->count();
        $cancelledOrders = Transaction::where('status', 'cancelled')->count();

        return view('staff.orders.index', compact(
            'transactions',
            'status',
            'totalOrders',
            'completedOrders',
            'cancelledOrders'
        ));
    }

    public function edit(Transaction $transaction)
    {
        $transaction->load('details.product', 'shipping', 'latestPayment');

        return view('staff.orders.edit', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'shipping_status' => 'required|in:packing,shipped,delivered',
            'tracking_number' => 'nullable|string|max:100'
        ]);

        $status = $validated['shipping_status'] === 'delivered' ? 'completed' : 'processing';

        $transaction->update([
            'shipping_status' => $validated['shipping_status'],
            'status' => $status
        ]);

        if (!empty($validated['tracking_number'])) {
            $shipping = $transaction->shipping ?? new Shipping();
            $shipping->fill([
                'transaction_id' => $transaction->id,
                'address' => $transaction->shipping_address ?? '-',
                'courier' => $transaction->shipping_courier ?? 'J&T Express',
                'tracking_number' => $validated['tracking_number'],
                'shipped_by' => Auth::id(),
                'shipped_at' => $shipping->shipped_at ?? now()
            ]);
            $shipping->save();
        }

        return redirect()->route('staff.orders.edit', $transaction)
            ->with('success', 'Status barang berhasil diperbarui');
    }

    public function updatePaymentStatus(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,paid,failed,refunded'
        ]);

        $transaction->update([
            'payment_status' => $validated['payment_status'],
            'status' => $validated['payment_status'] === 'paid'
                ? ($transaction->status === 'pending' ? 'processing' : $transaction->status)
                : $transaction->status
        ]);

        return redirect()->route('staff.orders.edit', $transaction)
            ->with('success', 'Status konfirmasi berhasil diperbarui');
    }

    public function confirmPayment(Transaction $transaction)
    {
        $transaction->update([
            'payment_status' => 'paid',
            'status' => $transaction->status === 'pending' ? 'processing' : $transaction->status
        ]);

        return redirect()->route('staff.orders.edit', $transaction)
            ->with('success', 'Pembayaran berhasil dikonfirmasi');
    }

    public function cancel(Transaction $transaction)
    {
        if ($transaction->status === 'cancelled') {
            return redirect()->route('staff.orders.index')
                ->with('info', 'Pesanan sudah dibatalkan sebelumnya');
        }

        \DB::beginTransaction();

        try {
            $transaction->load('details.product');

            foreach ($transaction->details as $detail) {
                if ($detail->product) {
                    $detail->product->increment('stock', $detail->quantity);
                }
            }

            $transaction->update([
                'status' => 'cancelled',
                'payment_status' => 'failed'
            ]);

            \DB::commit();

            return redirect()->route('staff.orders.index')
                ->with('success', 'Pesanan berhasil dibatalkan');
        } catch (\Exception $e) {
            \DB::rollBack();

            return redirect()->route('staff.orders.index')
                ->with('error', 'Gagal membatalkan pesanan');
        }
    }
}
