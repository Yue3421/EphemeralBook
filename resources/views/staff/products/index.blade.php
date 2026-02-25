@extends('layouts.staff')

@section('title', 'Daftar Produk - Ephemeralbook')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-12">
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-semibold">Daftar Produk</h2>
            
            <!-- Tombol Tambah Produk -->
            <a href="{{ route('staff.products.create') }}" 
            class="bg-gray-600 hover:bg-gray-700 px-7 py-3 rounded-2xl font-medium transition flex items-center gap-2">
            <span>Tambah Produk</span>
</a>
        </div>

        @if($products->isEmpty())
            <div class="bg-gray-800 rounded-3xl p-16 text-center">
                <p class="text-3xl text-gray-400">Belum ada produk</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($products as $product)
                <div class="bg-gray-800 rounded-3xl p-6 flex items-center gap-8">
                    <!-- Cover Buku -->
                    <div class="w-28 h-36 bg-gray-700 rounded-2xl overflow-hidden flex-shrink-0 shadow-md">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-gray-500">
                                NO IMAGE
                            </div>
                        @endif
                    </div>

                    <!-- Info Produk -->
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold tracking-wider">
                            {{ strtoupper($product->name ?? $product->title) }}
                        </h3>
                        
                        <div class="mt-6 flex items-center gap-16">
                            <div>
                                <span class="text-gray-400 text-sm block">STOK</span>
                                <span class="text-3xl font-semibold text-white">{{ $product->stock }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 text-sm block">HARGA</span>
                                <span class="text-3xl font-semibold text-emerald-400">
                                    {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-3 w-40">
                        <a href="#" 
                        class="bg-blue-600 hover:bg-blue-700 text-center py-3.5 rounded-2xl font-semibold text-sm transition">
                            EDIT
                        </a>
                        
                        <form action="{{ route('staff.products.destroy', $product) }}" 
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus {{ $product->name ?? $product->title }} ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 w-full py-3.5 rounded-2xl font-semibold text-sm transition">
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