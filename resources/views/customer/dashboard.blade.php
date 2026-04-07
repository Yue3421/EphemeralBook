@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <style>
        body {
            background-color: #37353E;
            color: #E8E5DF;
        }
        .hero-card {
            background-image:
                linear-gradient(135deg, rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.55)),
                url('{{ asset('images/hero-image.jpeg') }}');
            background-size: cover;
            background-position: center;
        }
        .layer {
            background: rgba(0, 0, 0, 0.25);
            position : relative;
        }
        .soft-shadow {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }
    </style>

    <div class="tail-container px-8 py-10">
        {{-- HERO --}}
        <section class="mb-16">
            <div class="hero-card h-[260px] md:h-[320px] rounded-2xl soft-shadow flex items-center justify-center text-center">
                <div class="layer w-full h-full px-6 py-10 rounded-2xl justify-center items-center flex flex-col">
                <div class="px-6">
                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-white drop-shadow">
                        Selamat Datang,<br>Di Ephemeralbook
                    </h1>
                    <p class="mt-3 text-sm md:text-base text-white/90 font-medium">
                        Tempat jual buku Preloved kamu
                    </p>
                </div>
                </div>
            </div>
            <div class="mt-2 h-10 rounded-2xl bg-[#44444E] shadow-inner"></div>
        </section>

        {{-- PRODUCT --}}
        <section class="mb-20">
            <h2 class="text-xl md:text-2xl font-semibold mb-6 text-[#DCD7D1]">Product</h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="bg-[#4A4754] rounded-2xl p-3 flex flex-col soft-shadow hover:shadow-2xl transition-shadow">
                        <div class="w-full aspect-[3/4] rounded-xl bg-[#3C3A44] flex items-center justify-center overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="text-xs text-[#B8B2A9]">NO IMAGE</span>
                            @endif
                        </div>

                        <div class="mt-3">
                            <h3 class="text-sm font-semibold text-white line-clamp-2">{{ $product->name }}</h3>
                            <p class="text-xs text-[#C9C3BA]">{{ $product->author ?? 'Penulis tidak tersedia' }}</p>
                            <p class="mt-1 text-xs text-[#E6E1D8] font-semibold">
                                {{ $product->formatted_price ?? 'Rp 0' }}
                            </p>
                        </div>

                        <div class="mt-3 w-full bg-[#7A6A6A] hover:bg-[#6A5B5B] transition-colors px-3 py-2 rounded-xl text-xs text-white text-center">
                            Lihat Detail
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- ABOUT US --}}
        <section class="mb-24">
            <h2 class="text-xl md:text-2xl font-semibold mb-6 text-[#DCD7D1]">About Us</h2>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-4">
                    <div class="bg-[#D9D9D9] rounded-2xl p-6 flex items-center justify-center soft-shadow">
                        <img src="{{ asset('images/logo-ephemeral.png') }}"
                            alt="Logo Ephemeralbook"
                            class="w-48 h-48 object-contain">
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <p class="text-base md:text-lg leading-relaxed text-[#E6E1D8]">
                        Kami adalah tempat yang menjual buku - buku yang tidak ingin dibuang
                        tapi sudah kamu baca sampai bosan
                    </p>
                    <p class="mt-5 text-base md:text-lg leading-relaxed text-[#E6E1D8]">
                        Jika kamu ingin menjual buku, silahkan kontak kami.
                    </p>

                    <a href="{{ route('contact') }}"
                    class="mt-8 inline-flex bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors px-8 py-3 rounded-xl text-white font-semibold">
                        Kontak Kami
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
