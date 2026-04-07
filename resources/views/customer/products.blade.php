{{-- resources/views/customer/products.blade.php --}}
@extends('layouts.app')
@section('title', 'Product')
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
        <section class="mb-10">
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-[#DCD7D1]">Produk kami</h1>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-[240px,1fr] gap-6">
            {{-- SIDEBAR --}}
            <aside class="bg-[#6E5A5A] rounded-2xl p-6 soft-shadow">
                <h2 class="text-lg font-semibold mb-4 text-[#F1ECE6]">Kategori</h2>
                <ul class="space-y-3 text-sm text-[#F1ECE6]">
                    <li>
                        <a href="{{ route('products', array_filter(['search' => request('search')])) }}"
                           class="{{ request('category') ? 'opacity-80' : 'font-semibold' }}">
                            Semua
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('products', array_filter(['category' => $category, 'search' => request('search')])) }}"
                               class="{{ request('category') === $category ? 'font-semibold' : 'opacity-80' }}">
                                {{ $category }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            {{-- MAIN --}}
            <div class="space-y-5">
                <form action="{{ route('products') }}" method="GET" class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-600">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari buku..."
                        class="w-full bg-[#D9D9D9] text-zinc-900 placeholder:text-zinc-600 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    >
                </form>

                <div class="bg-[#4A4754] rounded-2xl p-6 min-h-[420px] soft-shadow">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @forelse($products as $product)
                            <a href="{{ route('products.show', $product) }}" class="block bg-[#3C3A44] rounded-2xl p-4 border border-[#2F2D36] hover:border-[#8B7B7B] transition-colors">
                                <div class="w-full aspect-[4/5] rounded-xl bg-[#2F2D36] flex items-center justify-center overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/'.$product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs text-[#B8B2A9]">NO IMAGE</span>
                                    @endif
                                </div>

                                <div class="mt-4 space-y-1">
                                    <h3 class="text-base font-semibold text-white">{{ $product->name }}</h3>
                                    <p class="text-xs text-[#C9C3BA]">{{ $product->author ?? 'Penulis tidak tersedia' }}</p>
                                    <p class="text-sm text-[#E6E1D8] font-semibold">
                                        {{ $product->formatted_price ?? 'Rp 0' }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full text-center text-sm text-[#C9C3BA] py-16">
                                Produk belum tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
