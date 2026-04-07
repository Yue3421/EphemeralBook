{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'User List')
@section('content')
    <div class="max-w-6xl mx-auto px-8 py-12">
        <section class="bg-[#6E5A5A] rounded-2xl soft-shadow overflow-hidden">
            <div class="px-6 py-4 flex items-center justify-between border-b border-[#7A6A6A]">
                <h1 class="text-lg font-semibold text-white">Daftar Pengguna</h1>
            </div>

            <div class="grid grid-cols-[1fr,1fr,120px] text-xs text-[#E6E1D8] px-6 py-3 border-b border-[#7A6A6A] bg-[#3C3A44]">
                <div>Nama Lengkap</div>
                <div>Alamat</div>
                <div class="text-right">ID</div>
            </div>

            @forelse($users as $user)
                <div class="grid grid-cols-[1fr,1fr,120px] items-center px-6 py-3 text-sm text-white border-b border-[#7A6A6A] bg-[#715A5A]">
                    <div>{{ $user->name }}</div>
                    <div>{{ $user->addresses->first()?->formatted_address ?? '-' }}</div>
                    <div class="text-right">{{ $user->id }}</div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-[#E6E1D8]">
                    Belum ada pengguna.
                </div>
            @endforelse
        </section>
    </div>
@endsection
