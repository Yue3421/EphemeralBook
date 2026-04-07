{{-- resources/views/customer/transaction/checkout.blade.php --}}
@extends('layouts.app')
@section('title', 'Detail Pembayaran')
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
        <section class="mb-8 text-center">
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-[#DCD7D1]">Detail Pembayaran</h1>
        </section>

        <section class="flex justify-center">
            <form action="{{ route('checkout.store') }}" method="POST" class="w-full max-w-3xl">
                @csrf

                <div class="bg-[#4A4754] rounded-2xl p-6 soft-shadow space-y-6">
                    <a href="{{ route('addresses.index') }}" class="w-full bg-[#5B5663] hover:bg-[#6A6572] transition-colors px-5 py-3 rounded-2xl flex items-center justify-between">
                        <span class="text-sm md:text-base font-semibold text-[#E6E1D8]">Tambah/Ubah Alamat</span>
                        <span class="w-12 h-7 rounded-full bg-[#8B7B7B] flex items-center justify-center">
                            <i class="fa-solid fa-angle-right text-white"></i>
                        </span>
                    </a>

                    <input type="hidden" name="shipping_address" value="{{ old('shipping_address', $shippingAddress ?? '-') }}">

                    @if(!empty($defaultAddress))
                        <p class="text-xs text-[#C9C3BA]">
                            {{ $defaultAddress->label }} • {{ $shippingAddress }}
                        </p>
                    @endif

                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="flex items-center justify-between bg-[#3C3A44] rounded-2xl px-4 py-3">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-[#2F2D36] overflow-hidden flex items-center justify-center">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/'.$item->product->image) }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <span class="text-[10px] text-[#B8B2A9]">NO IMAGE</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">{{ $item->product?->name ?? 'Produk' }}</p>
                                        <p class="text-xs text-[#C9C3BA]">{{ $item->product?->author ?? 'Penulis tidak tersedia' }}</p>
                                    </div>
                                </div>
                                <div class="text-sm font-semibold text-[#E6E1D8]">
                                    {{ $item->product?->formatted_price ?? 'Rp 0' }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-semibold text-[#E6E1D8] mb-2">Methode Pembayaran</p>
                            <label class="inline-flex items-center gap-3 bg-[#3C3A44] rounded-full px-4 py-2 cursor-pointer">
                                <input type="radio" name="payment_method" value="qris" class="accent-[#8B7B7B]" required>
                                <span class="text-sm font-semibold text-white">QRIS</span>
                            </label>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-[#E6E1D8] mb-2">Methode Pengiriman</p>
                            <div class="flex flex-wrap gap-3">
                                <label class="inline-flex items-center gap-3 bg-[#3C3A44] rounded-full px-4 py-2 cursor-pointer">
                                    <input type="radio" name="shipping_courier" value="J&T Express" class="accent-[#8B7B7B]" required>
                                    <span class="text-sm font-semibold text-white">J&T Express</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center pt-4">
                        <div class="bg-[#8B7B7B] rounded-full px-8 py-3 flex items-center gap-6 w-full max-w-lg justify-between soft-shadow">
                            <span class="text-sm font-semibold text-white">
                                Total : Rp {{ number_format($total ?? 0, 0, ',', '.') }}
                            </span>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 transition-colors px-6 py-2 rounded-full text-sm text-white font-semibold">
                                BAYAR
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
