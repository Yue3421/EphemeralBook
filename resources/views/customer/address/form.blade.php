{{-- resources/views/customer/address/form.blade.php --}}
@extends('layouts.app')
@section('title', 'Detail Alamat')
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
            <div class="flex items-center justify-center relative">
                <a href="{{ route('addresses.index') }}" class="absolute left-0 bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors px-4 py-2 rounded-full text-sm text-white font-semibold">
                    <i class="fa-solid fa-angle-left mr-2"></i>Kembali
                </a>
                <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-[#DCD7D1]">Detail Alamat</h1>
            </div>
        </section>

        <section class="flex justify-center">
            <form
                action="{{ $address->exists ? route('addresses.update', $address) : route('addresses.store') }}"
                method="POST"
                class="w-full max-w-2xl bg-[#4A4754] rounded-2xl p-6 soft-shadow space-y-4"
            >
                @csrf
                @if($address->exists)
                    @method('PUT')
                @endif

                <input
                    type="text"
                    name="recipient_name"
                    value="{{ old('recipient_name', $address->recipient_name) }}"
                    placeholder="Nama Penerima"
                    class="w-full bg-[#3C3A44] text-[#E6E1D8] placeholder:text-[#B8B2A9] rounded-full px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    required
                >

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $address->phone) }}"
                    placeholder="No. Telp."
                    class="w-full bg-[#3C3A44] text-[#E6E1D8] placeholder:text-[#B8B2A9] rounded-full px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    required
                >

                <input
                    type="text"
                    name="label"
                    value="{{ old('label', $address->label ?? 'RUMAH') }}"
                    placeholder="Label"
                    class="w-full bg-[#3C3A44] text-[#E6E1D8] placeholder:text-[#B8B2A9] rounded-full px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    required
                >

                <input
                    type="text"
                    name="province"
                    value="{{ old('province', $address->province) }}"
                    placeholder="Provinsi"
                    class="w-full bg-[#3C3A44] text-[#E6E1D8] placeholder:text-[#B8B2A9] rounded-full px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    required
                >

                <input
                    type="text"
                    name="city"
                    value="{{ old('city', $address->city) }}"
                    placeholder="Kota"
                    class="w-full bg-[#3C3A44] text-[#E6E1D8] placeholder:text-[#B8B2A9] rounded-full px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    required
                >

                <input
                    type="text"
                    name="district"
                    value="{{ old('district', $address->district) }}"
                    placeholder="Kecamatan"
                    class="w-full bg-[#3C3A44] text-[#E6E1D8] placeholder:text-[#B8B2A9] rounded-full px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    required
                >

                <input
                    type="text"
                    name="postal_code"
                    value="{{ old('postal_code', $address->postal_code) }}"
                    placeholder="Kode Pos"
                    class="w-full bg-[#3C3A44] text-[#E6E1D8] placeholder:text-[#B8B2A9] rounded-full px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    required
                >

                <textarea
                    name="address_line"
                    rows="6"
                    placeholder="Alamat Lengkap"
                    class="w-full bg-[#3C3A44] text-[#E6E1D8] placeholder:text-[#B8B2A9] rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    required
                >{{ old('address_line', $address->address_line) }}</textarea>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors px-8 py-2 rounded-xl text-sm text-white font-semibold">
                        SIMPAN
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
