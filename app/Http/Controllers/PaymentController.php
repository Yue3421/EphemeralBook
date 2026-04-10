<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; 
use Illuminate\Http\JsonResponse; 
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Tampilkan form upload bukti pembayaran.
     */
    public function create(Transaction $transaction)
    {
        // Pastikan transaksi milik user
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        // Cek apakah sudah ada pembayaran pending
        $existingPayment = Payment::where('transaction_id', $transaction->id)
            ->where('status', 'pending')
            ->first();

        if ($existingPayment) {
            return redirect()->route('orders')
                ->with('info', 'Anda sudah mengupload bukti pembayaran. Silakan tunggu konfirmasi.');
        }

        return view('customer.payment.create', compact('transaction'));
    }

    /**
     * Upload bukti pembayaran.
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'payment_method' => 'required|in:bank_transfer,e_wallet,cash',
            'amount' => 'required|numeric|min:0',
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bank_name' => 'required_if:payment_method,bank_transfer|nullable|string',
            'account_number' => 'required_if:payment_method,bank_transfer|nullable|string',
            'account_name' => 'required_if:payment_method,bank_transfer|nullable|string',
            'payment_date' => 'required|date'
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);

        // Pastikan transaksi milik user
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        // Cek apakah transaksi sudah lunas
        if ($transaction->payment_status === 'paid') {
            return back()->with('error', 'Transaksi ini sudah lunas');
        }

        // Cek apakah sudah ada pembayaran pending
        $existingPayment = Payment::where('transaction_id', $transaction->id)
            ->where('status', 'pending')
            ->first();

        if ($existingPayment) {
            return back()->with('error', 'Anda sudah mengupload bukti pembayaran. Silakan tunggu konfirmasi.');
        }

        // Upload bukti pembayaran
        $path = $request->file('proof')->store('payments', 'public');

        // Buat record pembayaran
        $payment = Payment::create([
            'transaction_id' => $transaction->id,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'proof_url' => $path,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'payment_date' => $request->payment_date,
            'status' => 'pending',
            'submitted_by' => Auth::id()
        ]);

        // Update status transaksi (gunakan nilai enum yang valid)
        $transaction->update([
            'payment_status' => 'unpaid'
        ]);

        return redirect()->route('orders')
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi admin.');
    }

    /**
     * Konfirmasi pembayaran (khusus admin/staff).
     */
    public function confirm(Request $request, Payment $payment)
    {
        // Cek role
        if (!in_array(Auth::user()->role, ['admin', 'staff'])) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $payment->update([
                'status' => $request->status,
                'confirmed_by' => Auth::id(),
                'confirmed_at' => now(),
                'notes' => $request->notes
            ]);

            // Update transaksi
            if ($request->status === 'approved') {
                $payment->transaction->update([
                    'payment_status' => 'paid',
                    'status' => 'processing'
                ]);
            } else {
                $payment->transaction->update([
                    'payment_status' => 'unpaid'
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Pembayaran berhasil dikonfirmasi',
                'data' => $payment
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Daftar pembayaran pending (khusus admin/staff).
     */
    public function pendingPayments()
    {
        $payments = Payment::with('transaction.user', 'submittedBy')
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.payments.pending', compact('payments'));
    }

    /**
     * Riwayat pembayaran user.
     */
    public function history()
    {
        $payments = Payment::with('transaction')
            ->whereHas('transaction', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(10);

        return view('customer.payment.history', compact('payments'));
    }
}