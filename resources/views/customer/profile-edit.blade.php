{{-- resources/views/customer/profile-edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit Profile')
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

    @php
        $user = auth()->user();
    @endphp

    <div class="tail-container px-8 py-10">
        <section class="flex justify-center">
            <div class="w-full max-w-5xl bg-[#4A4754] rounded-2xl p-8 soft-shadow">
                <div class="grid grid-cols-1 lg:grid-cols-[260px,1fr] gap-8 items-center">
                    <div class="flex justify-center">
                        <div class="w-48 h-48 rounded-2xl overflow-hidden border-4 border-[#2F2D36] bg-[#2F2D36]">
                            <img src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : asset('images/profile.jpg') }}"
                                alt="Profile"
                                class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-lg font-semibold text-white uppercase">{{ $user->name ?? 'Nama User' }}</p>
                                <p class="text-sm text-[#C9C3BA]">{{ $user->email ?? 'email@contoh.com' }}</p>
                            </div>
                            <a href="{{ route('profile') }}" class="bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors px-4 py-2 rounded-lg text-xs text-white font-semibold">
                                Kembali
                            </a>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-xs text-[#C9C3BA] mb-1">Nama lengkap</label>
                                <input type="text"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="w-full bg-white text-zinc-900 rounded-lg px-4 py-3"
                                    required>
                            </div>
                            <div>
                                <label class="block text-xs text-[#C9C3BA] mb-1">Email</label>
                                <input type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="w-full bg-white text-zinc-900 rounded-lg px-4 py-3"
                                    required>
                            </div>
                            <div>
                                <label class="block text-xs text-[#C9C3BA] mb-1">No. Telp.</label>
                                <input type="text"
                                    name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="w-full bg-white text-zinc-900 rounded-lg px-4 py-3">
                            </div>

                            <div>
                                <label class="block text-xs text-[#C9C3BA] mb-1">Foto Profile</label>
                                <input type="file"
                                    name="profile_photo"
                                    accept=".jpg,.jpeg,.png"
                                    class="w-full bg-white text-zinc-900 rounded-lg px-4 py-3">
                            </div>

                            <div class="flex flex-wrap items-center gap-3 pt-2">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 transition-colors px-6 py-2 rounded-lg text-xs text-white font-semibold">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
