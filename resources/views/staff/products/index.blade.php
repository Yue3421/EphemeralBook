@extends('layouts.staff')

@section('title', 'Daftar Produk - Ephemeralbook')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-xl md:text-2xl font-semibold text-[#DCD7D1]">Daftar Produk</h2>

            <a href="{{ route('staff.products.create') }}"
               class="bg-[#8B7B7B] hover:bg-[#7A6A6A] px-5 py-2 rounded-full font-medium transition text-sm text-white">
                Tambah Produk
            </a>
        </div>

        @if($products->isEmpty())
            <div class="bg-[#44444E] rounded-3xl p-16 text-center">
                <p class="text-3xl text-gray-400">Belum ada produk</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($products as $product)
                <div class="bg-[#4A4754] rounded-2xl p-4 flex items-center gap-5">
                    <!-- Cover Buku -->
                    <div class="w-20 h-18 bg-[#2F2D36] rounded-xl overflow-hidden flex-shrink-0 shadow-md">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" 
                                alt="{{ $product->name ?? $product->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-gray-500">
                                NO IMAGE
                            </div>
                        @endif
                    </div>

                    <!-- Info Produk -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold tracking-wide text-white">
                            {{ strtoupper($product->name ?? $product->title) }}
                        </h3>
                    </div>

                    <div class="text-right text-sm text-[#E6E1D8] pr-4">
                        <div>STOK : {{ $product->stock }}</div>
                        <div>HARGA : {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-2 w-28">
                        <a href="{{ route('staff.products.edit', $product) }}" 
                        class="bg-blue-600 hover:bg-blue-700 text-center py-2.5 rounded-full font-semibold text-xs transition">
                            EDIT
                        </a>
                        
                        <form action="{{ route('staff.products.destroy', $product) }}" 
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus {{ $product->name ?? $product->title }} ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 w-full py-2.5 rounded-full font-semibold text-xs transition">
                                HAPUS
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
