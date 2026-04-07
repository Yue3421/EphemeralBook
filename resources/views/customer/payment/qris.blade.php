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

                        <div class="flex items-center justify-between text-2xl font-semibold text-white">
                            <span>Mohon agar bukti pembayaran di screenshot, Terimakasih</span>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <img
                            src="{{ asset('images/qris.jpeg') }}"
                            alt="QRIS"
                            class="w-full max-w-[280px] rounded-2xl shadow-lg bg-white p-1"
                        >
                    </div>
                </div>

                <div class="flex justify-center mt-8">
                    <button id="confirmPaymentBtn" type="button" class="bg-green-600 hover:bg-green-700 transition-colors px-6 py-2 rounded-full text-sm text-white font-semibold">
                        Konfirmasi
                    </button>
                </div>
            </div>
        </section>
    </div>

    {{-- Success Popup --}}
    <div id="paymentSuccessModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-6">
        <div class="w-full max-w-md bg-[#4A4754] rounded-2xl p-6 text-center soft-shadow">
            <h2 class="text-xl font-semibold text-white mb-2">Pembayaran Berhasil</h2>
            <p class="text-sm text-[#E6E1D8] mb-6">
                Terima kasih! Pembayaran kamu berhasil dan sedang diproses.
            </p>
            <div class="flex items-center justify-center gap-3">
                <button id="closePaymentModal" type="button" class="bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors px-5 py-2 rounded-full text-xs text-white font-semibold">
                    Tutup
                </button>
                <a href="{{ route('orders') }}" class="bg-green-600 hover:bg-green-700 transition-colors px-5 py-2 rounded-full text-xs text-white font-semibold">
                    Lihat Pesanan
                </a>
            </div>
        </div>
    </div>

    <script>
        const confirmBtn = document.getElementById('confirmPaymentBtn');
        const modal = document.getElementById('paymentSuccessModal');
        const closeBtn = document.getElementById('closePaymentModal');

        if (confirmBtn && modal) {
            confirmBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    window.location.href = "{{ route('orders') }}";
                }, 1500);
            });
        }

        if (closeBtn && modal) {
            closeBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        }
    </script>
@endsection
