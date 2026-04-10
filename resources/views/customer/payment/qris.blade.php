{{-- resources/views/customer/payment/qris.blade.php --}}
@extends('layouts.app')
@section('title', 'Pembayaran')
@section('content')
    <style>
        body {
            background-color: #37353E;
            color: #E8E5DF;
        }
        .soft-shadow {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }
    </style>

    <div class="tail-container px-8 py-10">
        <section class="mb-6 text-center">
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-[#DCD7D1]">Pembayaran</h1>
        </section>

        <section class="flex justify-center">
            <div class="w-full max-w-4xl bg-[#4A4754] rounded-2xl p-8 soft-shadow">
                <p class="text-center text-sm text-[#E6E1D8] mb-6">
                    Scan QRIS dan bayar sesuai dengan total harga
                </p>

                <div class="grid grid-cols-1 md:grid-cols-[1fr,320px] gap-8 items-center">
                    <div class="bg-[#3C3A44] rounded-2xl p-6 border border-[#5B5663]">
                        <h2 class="text-sm font-semibold text-white mb-4">Rincian Pembayaran</h2>

                        <div class="space-y-3 text-sm text-[#E6E1D8]">
                            <div class="flex items-center justify-between">
                                <span>Total Harga ({{ $itemsCount }} Barang)</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Biaya Pengiriman</span>
                                <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="border-t border-[#6A6572] my-4"></div>

                        <div class="flex items-center justify-between text-sm font-semibold text-white my-5">
                            <span>TOTAL</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <p class="text-xs text-[#E6E1D8] mb-4">
                            Mohon upload bukti pembayaran agar pesanan bisa diproses.
                        </p>

                        <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                            <input type="hidden" name="payment_method" value="e_wallet">
                            <input type="hidden" name="amount" value="{{ $total }}">

                            <input type="date"
                                   name="payment_date"
                                   required
                                   class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-white"
                                   value="{{ now()->format('Y-m-d') }}">

                            <input type="file"
                                   name="proof"
                                   accept=".jpg,.jpeg,.png"
                                   required
                                   class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-white">

                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 transition-colors px-4 py-2 rounded-full text-xs text-white font-semibold">
                                Upload Bukti Pembayaran
                            </button>
                        </form>
                    </div>

                    <div class="flex justify-center">
                        <img
                            src="{{ asset('images/qris.jpeg') }}"
                            alt="QRIS"
                            class="w-full max-w-[280px] rounded-2xl shadow-lg bg-white p-1"
                        >
                    </div>
                </div>

                <div class="flex justify-center mt-8 text-xs text-[#E6E1D8]">
                    Setelah upload bukti, status akan menunggu konfirmasi admin.
                </div>
            </div>
        </section>
    </div>
@endsection
