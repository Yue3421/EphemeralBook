{{-- resources/views/admin/staff/create.blade.php --}}
@extends('layouts.admin')
@section('title', 'Tambah Petugas')
@section('content')
    <div class="max-w-4xl mx-auto px-8 py-16">
        <section class="text-center mb-10">
            <h1 class="text-2xl md:text-3xl font-semibold text-[#DCD7D1]">Tambah Petugas</h1>
        </section>

        <section class="flex justify-center">
            <form action="{{ route('admin.staff.store') }}" method="POST" class="w-full max-w-xl space-y-4">
                @csrf

                <input type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="NAMA"
                    class="w-full bg-[#4A4754] text-white placeholder:text-[#C9C3BA] rounded-full px-6 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    required>

                <input type="password"
                    name="password"
                    placeholder="PASSWORD"
                    class="w-full bg-[#4A4754] text-white placeholder:text-[#C9C3BA] rounded-full px-6 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    required>

                <input type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="EMAIL"
                    class="w-full bg-[#4A4754] text-white placeholder:text-[#C9C3BA] rounded-full px-6 py-3 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                    required>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('admin.staff.index') }}"
                    class="bg-red-600 hover:bg-red-700 transition-colors px-8 py-2 rounded-full text-xs text-white font-semibold">
                        BATAL
                    </a>
                    <button type="submit"
                            class="bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors px-8 py-2 rounded-full text-xs text-white font-semibold">
                        Simpan
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
