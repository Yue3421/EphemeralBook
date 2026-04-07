{{-- resources/views/admin/reports/transactions.blade.php --}}
@extends('layouts.admin')
@section('title', 'Report Transaksi')
@section('content')
    <div class="max-w-7xl mx-auto px-8 py-12">
        <section class="text-center">
            <h1 class="text-2xl md:text-3xl font-semibold text-[#DCD7D1] mb-3">Report Transaksi</h1>
            <p class="text-sm text-[#C9C3BA] mb-6">
                Halaman ini belum digunakan. Silakan gunakan halaman Report Penjualan.
            </p>
            <a href="{{ route('admin.reports.sales') }}"
               class="inline-flex bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors px-6 py-3 rounded-xl text-white font-semibold text-sm">
                Buka Report Penjualan
            </a>
        </section>
    </div>
@endsection
