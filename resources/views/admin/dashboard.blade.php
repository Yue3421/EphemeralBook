{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
    <div class="max-w-7xl mx-auto px-8 py-12">
        <section class="flex items-center justify-between mb-8">
            <h1 class="text-2xl md:text-3xl font-semibold text-[#DCD7D1]">
                SELAMAT DATANG, {{ strtoupper($user->name ?? 'Admin') }}
            </h1>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-[#4A4754] rounded-2xl p-6 soft-shadow">
                <p class="text-sm text-[#C9C3BA]">Total Pesanan</p>
                <p class="text-2xl font-semibold text-white">{{ $totalOrders }}</p>
            </div>
            <div class="bg-[#4A4754] rounded-2xl p-6 soft-shadow">
                <p class="text-sm text-[#C9C3BA]">Pesanan Selesai</p>
                <p class="text-2xl font-semibold text-white">{{ $completedOrders }}</p>
            </div>
            <div class="bg-[#4A4754] rounded-2xl p-6 soft-shadow">
                <p class="text-sm text-[#C9C3BA]">Pesanan Dibatalkan</p>
                <p class="text-2xl font-semibold text-white">{{ $cancelledOrders }}</p>
            </div>
        </section>
    </div>
@endsection
