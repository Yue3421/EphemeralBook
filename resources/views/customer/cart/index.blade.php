{{-- resources/views/customer/cart/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Keranjang')
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
        <section class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-[#DCD7D1]">KERANJANG</h1>
        </section>

        <section class="space-y-8">
            @forelse($cartItems as $item)
                @php
                    $product = $item->product;
                    $canDecrease = $item->quantity > 1;
                    $canIncrease = $product && $product->stock !== null ? $item->quantity < $product->stock : true;
                @endphp

                <div class="bg-[#4A4754] rounded-2xl p-5 soft-shadow flex flex-col md:flex-row md:items-center gap-6">
                    <div class="flex items-center gap-5 flex-1">
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
                            <p class="text-lg font-semibold text-white">{{ $product?->name ?? 'Produk tidak ditemukan' }}</p>
                            <p class="text-sm text-[#C9C3BA]">{{ $product?->author ?? 'Penulis tidak tersedia' }}</p>
                        </div>
                    </div>

                    <div class="text-lg font-semibold text-[#E6E1D8]">
                        {{ $product?->formatted_price ?? 'Rp 0' }}
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="flex items-center bg-[#2F2D36] rounded-full px-3 py-1.5 text-white">
                            <form action="{{ route('cart.update', $item) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                <button type="submit" class="px-2" {{ $canDecrease ? '' : 'disabled' }}>-</button>
                            </form>

                            <span class="px-4 text-sm font-semibold">{{ $item->quantity }}</span>

                            <form action="{{ route('cart.update', $item) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                <button type="submit" class="px-2" {{ $canIncrease ? '' : 'disabled' }}>+</button>
                            </form>
                        </div>

                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 transition-colors px-4 py-2 rounded-xl text-sm text-white font-semibold">
                                HAPUS
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-sm text-[#C9C3BA] py-16">
                    Keranjang kamu masih kosong.
                </div>
            @endforelse

            <div class="flex justify-center">
                <div class="bg-[#8B7B7B] rounded-full px-8 py-3 flex items-center gap-6 w-full max-w-lg justify-between soft-shadow">
                    <span class="text-sm font-semibold text-white">
                        Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}
                    </span>
                    <a href="{{ route('checkout') }}" class="bg-green-600 hover:bg-green-700 transition-colors px-6 py-2 rounded-full text-sm text-white font-semibold">
                        BAYAR
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
