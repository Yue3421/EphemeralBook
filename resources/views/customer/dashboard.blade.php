{{-- resources/views/customer/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    {{-- HERO BANNER --}}
    <section class="hero-bg h-[500px] flex items-center relative">
        <div class="tail-container px-8 relative z-10 text-center">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-6xl md:text-7xl font-bold leading-none text-white tracking-tighter">
                    Selamat Datang<br>Di Ephemeralbook
                </h1>
                <p class="mt-6 text-2xl text-white/90 font-light">
                    Tempat jual buku Preloved kamu
                </p>
            </div>
        </div>
    </section>

    {{-- PRODUCT SECTION --}}
    <section class="py-16 bg-zinc-900">
        <div class="tail-container px-8">
            <h2 class="text-4xl font-semibold mb-10">Product</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                    <div class="bg-zinc-800 rounded-3xl overflow-hidden">
                        <div class="bg-zinc-700 p-6 flex items-center justify-center h-72">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-40 shadow-xl rounded-2xl">
                            @else
                                <span class="text-gray-400 text-sm">NO IMAGE</span>
                            @endif
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
                            <p class="text-zinc-400 mt-1">{{ $product->author }}</p>

                            <p class="text-emerald-400 text-2xl font-bold mt-6">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            <button
                                class="mt-6 w-full bg-amber-700 hover:bg-amber-800 py-3 rounded-xl text-white">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT US (LOGO SUDAH DIGANTI JADI FOTO) --}}
    <section class="py-20 bg-zinc-900 border-t border-zinc-800">
        <div class="tail-container px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                
                {{-- ← TEMPAT LOGO SEKARANG FOTO --}}
                <div class="lg:col-span-5 flex justify-center lg:justify-end">
                    <img src="{{ asset('images/logo-ephemeral.png') }}" 
                        alt="Logo Ephemeralbook" 
                        class="bg-gray-200 w-80 h-80 object-cover rounded-3xl shadow-2xl">
                </div>

                {{-- Text Content --}}
                <div class="lg:col-span-7">
                    <h2 class="text-4xl font-semibold mb-8">About Us</h2>
                    <div class="max-w-lg">
                        <p class="text-lg leading-relaxed text-zinc-300">
                            Kami adalah tempat yang menjual buku - buku yang tidak ingin dibuang 
                            tapi sudah kamu baca sampai bosan
                        </p>
                        <p class="mt-8 text-lg leading-relaxed text-zinc-300">
                            Jika kamu ingin menjual buku, silahkan kontak kami 😊
                        </p>
                        
                        <button onclick="window.location.href='https://wa.me/6285179572070'" 
                                class="mt-12 bg-amber-700 hover:bg-amber-800 transition-all px-14 py-5 rounded-2xl text-white font-semibold flex items-center gap-x-3">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                            Kontak Kami
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection