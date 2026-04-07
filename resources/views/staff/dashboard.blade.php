@extends('layouts.staff')

@section('title', 'Staff Dashboard - Ephemeralbook')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-14">
        <h2 class="text-2xl md:text-3xl font-semibold mb-12 text-[#DCD7D1]">
            SELAMAT DATANG, {{ Auth::user()->name ?? 'Staff' }}-san
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-1xl">

            <!-- Card Jumlah Buku -->
            <div class="bg-[#4A4754] border border-[#7A6A6A] rounded-2xl p-8 text-center">
                <div class="text-[#E6E1D8] text-lg font-semibold mb-3">JUMLAH BUKU</div>
                <div id="total-books"
                     class="text-5xl font-bold tabular-nums text-white">
                    {{ $totalBooks }}
                </div>
            </div>

            <!-- Card Jumlah Transaksi -->
            <div class="bg-[#4A4754] border border-[#7A6A6A] rounded-2xl p-8 text-center">
                <div class="text-[#E6E1D8] text-lg font-semibold mb-3">JUMLAH Transaksi</div>
                <div id="total-transactions"
                     class="text-5xl font-bold tabular-nums text-white">
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
