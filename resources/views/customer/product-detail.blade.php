{{-- resources/views/customer/product-detail.blade.php --}}
@extends('layouts.app')
@section('title', 'Detail Buku')
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
        <section class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-[#DCD7D1]">BUKU</h1>
        </section>

        <section class="space-y-8">
            {{-- TOP --}}
            <div class="grid grid-cols-1 lg:grid-cols-[200px,1fr] gap-6 items-start">
                <div class="bg-[#4A4754] rounded-2xl p-3 soft-shadow">
                    <div class="w-full aspect-[4/5] rounded-xl bg-[#2F2D36] flex items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <span class="text-xs text-[#B8B2A9]">NO IMAGE</span>
                        @endif
                    </div>
                </div>

                <div class="bg-[#4A4754] rounded-2xl p-6 soft-shadow">
                    <h2 class="text-2xl md:text-3xl font-bold text-white">{{ $product->name }}</h2>
                    <p class="text-sm text-[#C9C3BA] font-semibold">{{ $product->author ?? 'Penulis tidak tersedia' }}</p>

                    <div class="mt-3">
                        <p class="text-sm font-semibold text-[#E6E1D8] mb-1">Sinopsis</p>
                        <p class="text-sm leading-relaxed text-[#E6E1D8]">
                            {{ $product->description ?? 'Sinopsis belum tersedia untuk buku ini.' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- BOTTOM --}}
            <div class="grid grid-cols-1 lg:grid-cols-[280px,1fr,220px] gap-5 items-center">
                <div class="bg-[#4A4754] rounded-2xl p-6 soft-shadow">
                    <h3 class="text-lg font-semibold text-[#F1ECE6] mb-3">Keterangan</h3>
                    <ul class="text-sm text-[#E6E1D8] space-y-2 list-disc list-inside">
                        <li>Kondisi buku baik tanpa ada sobek</li>
                        <li>Kertas mulai menguning</li>
                        <li>Bookmark masih ada</li>
                    </ul>
                </div>

                <div class="text-center">
                    <p class="text-3xl md:text-4xl font-extrabold text-[#E6E1D8]">
                        STOK : {{ $product->stock ?? 0 }}
                    </p>
                </div>

                <div class="flex flex-col items-center gap-3">
                    <div class="text-xl md:text-2xl font-bold text-[#E6E1D8]">
                        {{ $product->formatted_price ?? 'Rp 0' }}
                    </div>

                    <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="w-full bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors px-4 py-2 rounded-xl text-sm text-white font-semibold">
                            Keranjang
                        </button>
                    </form>

                    <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="redirect" value="{{ route('checkout') }}">
                        <button type="submit" class="w-full border border-[#C9C3BA] hover:border-white transition-colors px-4 py-2 rounded-xl text-sm text-white font-semibold">
                            Beli Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection