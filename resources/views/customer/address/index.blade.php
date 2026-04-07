{{-- resources/views/customer/address/index.blade.php --}}
@extends('layouts.app')
@section('title', 'List Alamat')
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
            <div class="flex items-center justify-center relative">
                <a href="{{ route('checkout') }}" class="absolute left-0 bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors px-4 py-2 rounded-full text-xs text-white font-semibold">
                    <i class="fa-solid fa-angle-left mr-2"></i>Kembali
                </a>
                <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-[#DCD7D1]">List Alamat</h1>
            </div>
        </section>

        <section class="flex justify-center">
            <div class="w-full max-w-3xl space-y-4">
                <a href="{{ route('addresses.create') }}" class="w-full bg-[#4A4754] rounded-2xl px-6 py-4 flex items-center justify-between soft-shadow hover:shadow-2xl transition-shadow">
                    <span class="text-lg font-semibold text-[#E6E1D8]">Tambah Alamat</span>
                    <span class="w-14 h-8 rounded-full bg-[#8B7B7B] flex items-center justify-center text-white text-xl">+</span>
                </a>

                @forelse($addresses as $address)
                    <div class="w-full bg-[#4A4754] rounded-2xl px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4 soft-shadow hover:shadow-2xl transition-shadow">
                        <div>
                            <p class="text-lg font-semibold text-white">{{ strtoupper($address->label) }}</p>
                            <p class="text-xs text-[#C9C3BA]">{{ $address->formatted_address }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('addresses.edit', $address) }}" class="bg-blue-600 hover:bg-blue-700 transition-colors px-4 py-2 rounded-full text-xs text-white font-semibold">
                                Lihat Alamat
                            </a>
                            <form action="{{ route('addresses.default', $address) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 transition-colors px-4 py-2 rounded-full text-xs text-white font-semibold">
                                    Pakai Alamat
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-sm text-[#C9C3BA] py-12">
                        Belum ada alamat tersimpan.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
