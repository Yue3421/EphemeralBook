{{-- resources/views/admin/staff/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Staff List')
@section('content')
    <div class="max-w-6xl mx-auto px-8 py-12">
        <section class="bg-[#6E5A5A] rounded-2xl soft-shadow overflow-hidden">
            <div class="px-6 py-4 flex items-center justify-between">
                <h1 class="text-lg font-semibold text-white">Daftar Pengguna</h1>
                <a href="{{ route('admin.staff.create') }}"
                   class="bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors px-4 py-2 rounded-full text-xs text-white font-semibold">
                    Tambah Petugas
                </a>
            </div>

            <div class="grid grid-cols-[1fr,120px] text-xs text-[#E6E1D8] px-6 py-3 border-b border-[#7A6A6A] bg-[#3C3A44]">
                <div>Nama Lengkap</div>
                <div class="text-right">ID</div>
            </div>

            @forelse($staff as $user)
                <div class="grid grid-cols-[1fr,120px] items-center px-6 py-3 text-sm text-white border-b border-[#7A6A6A] bg-[#715A5A]">
                    <div>{{ $user->name }}</div>
                    <div class="text-right">{{ $user->id }}</div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-[#E6E1D8]">
                    Belum ada petugas.
                </div>
            @endforelse
        </section>
    </div>
@endsection
