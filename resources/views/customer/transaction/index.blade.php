{{-- resources/views/customer/transaction/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Pesanan')
@section('content')
    <style>
        body {
            background-color: #37353E;
            color: #E8E5DF;
        }
        .soft-shadow {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }
        details[open] summary .chevron {
            transform: rotate(180deg);
        }
    </style>

    <div class="tail-container px-8 py-10">
        <section class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-[#DCD7D1]">Semua Pesanan</h1>

            <div class="flex items-center gap-2 bg-[#8B7B7B] rounded-full p-1 text-xs">
                <a href="{{ route('orders') }}"
                class="px-4 py-2 rounded-full {{ empty($status) ? 'bg-[#6A5B5B] text-white' : 'text-[#F1ECE6]' }}">
                    Semua pesanan
                </a>
                <a href="{{ route('orders', ['status' => 'completed']) }}"
                class="px-4 py-2 rounded-full {{ $status === 'completed' ? 'bg-[#6A5B5B] text-white' : 'text-[#F1ECE6]' }}">
                    Selesai
                </a>
                <a href="{{ route('orders', ['status' => 'cancelled']) }}"
                class="px-4 py-2 rounded-full {{ $status === 'cancelled' ? 'bg-[#6A5B5B] text-white' : 'text-[#F1ECE6]' }}">
                    Dibatalkan
                </a>
            </div>
        </section>

        <section class="space-y-5">
            @forelse($transactions as $transaction)
                @php
                    $firstDetail = $transaction->details->first();
                    $product = $firstDetail?->product;
                    $itemsCount = $transaction->details->sum('quantity');
                    $paymentMethod = $transaction->latestPayment?->payment_method_label ?? 'QRIS';
                    $statusText = $transaction->status === 'cancelled'
                        ? 'Dibatalkan'
                        : ($transaction->payment_status === 'paid' ? 'Dikonfirmasi' : 'Menunggu konfirmasi admin');
                @endphp

                <details class="bg-[#4A4754] rounded-2xl p-5 soft-shadow">
                    <summary class="list-none cursor-pointer flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-xl bg-[#2F2D36] overflow-hidden flex items-center justify-center">
                                @if($product && $product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <span class="text-[10px] text-[#B8B2A9]">NO IMAGE</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-white">{{ $product?->name ?? 'Produk' }}</p>
                                <p class="text-sm text-[#C9C3BA]">{{ $product?->author ?? 'Penulis tidak tersedia' }}</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-angle-down text-white transition-transform chevron"></i>
                    </summary>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-[1fr,1fr] gap-4 text-sm text-[#E6E1D8]">
                        <div class="space-y-2">
                            <div class="flex items-start gap-2">
                                <span class="w-40">Status</span>
                                <span>:</span>
                                <span>{{ $statusText }}</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-40">Total Harga ({{ $itemsCount }} Barang)</span>
                                <span>:</span>
                                <span>Rp {{ number_format($transaction->subtotal ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-40">Biaya Pengiriman</span>
                                <span>:</span>
                                <span>Rp {{ number_format($transaction->shipping_cost ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-40">Metode Pembayaran</span>
                                <span>:</span>
                                <span>{{ $paymentMethod }}</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-40">Status Barang</span>
                                <span>:</span>
                                <span>
                                    @php
                                        $shippingStatus = $transaction->shipping_status;
                                        $shippingLabel = match($shippingStatus) {
                                            'shipped' => 'Dikirim',
                                            'delivered' => 'Diterima',
                                            'packing' => 'Sedang Diproses',
                                            default => 'Menunggu'
                                        };
                                    @endphp
                                    {{ $shippingLabel }}
                                </span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-40">ID Pesanan</span>
                                <span>:</span>
                                <span class="flex items-center gap-2">
                                    <span class="font-semibold text-white">{{ $transaction->invoice_code }}</span>
                                    <button type="button"
                                            class="px-2 py-1 text-[10px] rounded-full bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors text-white"
                                            onclick="copyOrderId('{{ $transaction->invoice_code }}', this)">
                                        Copy
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-start gap-2">
                                <span class="w-32">Alamat</span>
                                <span>:</span>
                                <span class="flex-1">{{ $transaction->shipping_address ?? '-' }}</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-32">Tanggal Pesanan</span>
                                <span>:</span>
                                <span>{{ $transaction->created_at?->format('d/m/Y') }}</span>
                            </div>
                            @if($transaction->shipping?->tracking_number)
                                <div class="flex items-start gap-2">
                                    <span class="w-32">Resi</span>
                                    <span>:</span>
                                    <span class="flex items-center gap-2">
                                        <span class="font-semibold text-white">{{ $transaction->shipping->tracking_number }}</span>
                                        <button type="button"
                                                class="px-2 py-1 text-[10px] rounded-full bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors text-white"
                                                onclick="copyOrderId('{{ $transaction->shipping->tracking_number }}', this)">
                                            Copy
                                        </button>
                                    </span>
                                </div>
                            @endif
                            @if($transaction->payment_status === 'unpaid')
                                <div class="flex items-start text-base font-semibold text-white">
                                    <span>Pesanan akan dikonfirmasi dalam kurang lebih dari 1x24 jam, Jika tanggal merah atau hari libur maka toko tutup, Terimakasih.</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($transaction->isCancellable())
                        <div class="mt-6 flex justify-end">
                            <form action="{{ route('orders.cancel', $transaction) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 transition-colors px-4 py-2 rounded-full text-xs text-white font-semibold">
                                    Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                    @endif

                    @if ($transaction->payment_status === 'unpaid')
                    <div class="mt-4 flex justify-end">
                        @php
                            $waText = urlencode("Halo admin, saya ingin verifikasi pembayaran. Kode invoice : " . $transaction->invoice_code);
                        @endphp
                        <a href="https://wa.me/6285117824604?text={{ $waText }}"
                        target="_blank"
                        rel="noopener"
                        class="bg-green-600 hover:bg-green-700 transition-colors px-4 py-2 rounded-full text-xs text-white font-semibold">
                            Verifikasi via WhatsApp
                        </a>
                    </div>
                    @endif
                </details>
            @empty
                <div class="text-center text-sm text-[#C9C3BA] py-16">
                    Belum ada pesanan.
                </div>
            @endforelse
        </section>
    </div>

    <script>
        function copyOrderId(text, button) {
            if (!navigator.clipboard) {
                return;
            }
            navigator.clipboard.writeText(text).then(() => {
                const original = button.textContent;
                button.textContent = 'Copied';
                setTimeout(() => {
                    button.textContent = original;
                }, 1200);
            });
        }
    </script>
@endsection
