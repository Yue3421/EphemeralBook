@extends('layouts.staff')

@section('title', 'Staff Dashboard - Ephemeralbook')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-12">
        <h2 class="text-3xl font-semibold mb-12">
            SELAMAT DATANG, <span class="text-emerald-400">{{ Auth::user()->name ?? 'Staff' }}-san</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Card Jumlah Buku -->
            <div class="bg-gray-800 border border-gray-600 rounded-3xl p-8 card">
                <div class="text-gray-400 text-lg font-medium mb-3">JUMLAH BUKU</div>
                <div id="total-books" 
                     class="text-7xl font-bold tabular-nums text-white">
                    {{ $totalBooks }}
                </div>
            </div>

            <!-- Card Jumlah Transaksi -->
            <div class="bg-gray-800 border border-gray-600 rounded-3xl p-8 card">
                <div class="text-gray-400 text-lg font-medium mb-3">JUMLAH Transaksi</div>
                <div id="total-transactions" 
                     class="text-6xl font-bold tabular-nums text-white">
                    {{ $totalTransactions }}
                </div>
            </div>
        </div>
    </div>

    <!-- Script auto refresh hanya untuk dashboard -->
    <script>
        function refreshCounts() {
            fetch("{{ route('staff.dashboard.counts') }}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-books').textContent = data.totalBooks;
                    document.getElementById('total-transactions').textContent = data.totalTransactions;
                });
        }

        window.addEventListener('load', () => {
            refreshCounts();
            setInterval(refreshCounts, 7000);
        });
    </script>
@endsection