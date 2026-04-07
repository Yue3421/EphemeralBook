{{-- resources/views/admin/reports/sales.blade.php --}}
@extends('layouts.admin')
@section('title', 'Laporan Penjualan')
@section('content')
    <div class="max-w-7xl mx-auto px-8 py-12">
        <section class="text-center mb-10">
            <h1 class="text-2xl md:text-3xl font-semibold text-[#DCD7D1]">Penjualan Bulanan</h1>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-[#4A4754] rounded-2xl p-5 soft-shadow">
                <p class="text-xs text-[#C9C3BA]">Total Pendapatan</p>
                <p class="text-xl font-semibold text-white">Rp {{ number_format($summary['total_revenue'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-[#4A4754] rounded-2xl p-5 soft-shadow">
                <p class="text-xs text-[#C9C3BA]">Total Petugas</p>
                <p class="text-xl font-semibold text-white">{{ $totalStaff }}</p>
            </div>
            <div class="bg-[#4A4754] rounded-2xl p-5 soft-shadow">
                <p class="text-xs text-[#C9C3BA]">Total Pengguna</p>
                <p class="text-xl font-semibold text-white">{{ $totalUsers }}</p>
            </div>
            <div class="bg-[#4A4754] rounded-2xl p-5 soft-shadow">
                <p class="text-xs text-[#C9C3BA]">Total Pesanan</p>
                <p class="text-xl font-semibold text-white">{{ $totalOrders }}</p>
            </div>
        </section>

        <section class="bg-[#D9D9D9] rounded-2xl p-6 soft-shadow">
            <canvas id="salesChart" height="140"></canvas>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthlySales = @json($monthlySales ?? []);
        const labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        const dataPoints = labels.map((_, index) => {
            const month = index + 1;
            return monthlySales[month] ? Number(monthlySales[month]) : 0;
        });

        const ctx = document.getElementById('salesChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Penjualan',
                    data: dataPoints,
                    borderColor: '#4F6EA1',
                    backgroundColor: 'rgba(79, 110, 161, 0.15)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#4F6EA1'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: { color: '#3C3A44' }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#3C3A44' },
                        grid: { color: 'rgba(60, 58, 68, 0.1)' }
                    },
                    y: {
                        ticks: { color: '#3C3A44' },
                        grid: { color: 'rgba(60, 58, 68, 0.1)' }
                    }
                }
            }
        });
    </script>
@endsection
