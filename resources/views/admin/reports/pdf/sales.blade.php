{{-- resources/views/admin/reports/pdf/sales.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Laporan Penjualan' }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #1f2937; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 6px; }
        .meta { font-size: 11px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; }
        .summary { margin-top: 12px; }
        .summary td { border: none; padding: 2px 0; }
    </style>
</head>
<body>
    <h1>{{ $title ?? 'Laporan Penjualan' }}</h1>
    <div class="meta">
        Periode: {{ $start_date ?? '-' }} s/d {{ $end_date ?? '-' }}<br>
        Generated: {{ $generated_at ?? '-' }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Total Transaksi</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salesData as $row)
                <tr>
                    <td>{{ $row->date }}</td>
                    <td>{{ $row->total_transactions }}</td>
                    <td>Rp {{ number_format($row->total_revenue ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td><strong>Total Transaksi:</strong> {{ $summary['total_transactions'] ?? 0 }}</td>
        </tr>
        <tr>
            <td><strong>Total Pendapatan:</strong> Rp {{ number_format($summary['total_revenue'] ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Rata-rata Transaksi:</strong> Rp {{ number_format($summary['average_transaction'] ?? 0, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>
</html>
