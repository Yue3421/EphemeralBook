{{-- resources/views/staff/orders/index.blade.php --}}
@extends('layouts.staff')
@section('title', 'Order List')
@section('content')
    <style>
        body {
            background-color: #3C3A44;
            color: #E8E5DF;
        }
        .soft-shadow {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }
    </style>

    <div class="max-w-7xl mx-auto px-8 py-10">
        <section class="mb-8">
            <h1 class="text-2xl md:text-3xl font-semibold text-[#DCD7D1]">Daftar Pesanan</h1>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-[#4A4754] rounded-2xl p-4 soft-shadow">
                <p class="text-xs text-[#C9C3BA]">Total Orders</p>
                <p class="text-2xl font-semibold text-white">{{ $totalOrders }}</p>
            </div>
            <div class="bg-[#4A4754] rounded-2xl p-4 soft-shadow">
                <p class="text-xs text-[#C9C3BA]">Completed Orders</p>
                <p class="text-2xl font-semibold text-white">{{ $completedOrders }}</p>
            </div>
            <div class="bg-[#4A4754] rounded-2xl p-4 soft-shadow">
                <p class="text-xs text-[#C9C3BA]">Canceled Orders</p>
                <p class="text-2xl font-semibold text-white">{{ $cancelledOrders }}</p>
            </div>
        </section>

        <section class="mb-6">
            <div class="inline-flex items-center gap-2 bg-[#8B7B7B] rounded-full p-1 text-xs">
                <a href="{{ route('staff.orders.index') }}"
                   class="px-4 py-2 rounded-full {{ empty($status) ? 'bg-[#6A5B5B] text-white' : 'text-[#F1ECE6]' }}">
                    Semua pesanan
                </a>
                <a href="{{ route('staff.orders.index', ['status' => 'completed']) }}"
                   class="px-4 py-2 rounded-full {{ $status === 'completed' ? 'bg-[#6A5B5B] text-white' : 'text-[#F1ECE6]' }}">
                    Selesai
                </a>
                <a href="{{ route('staff.orders.index', ['status' => 'cancelled']) }}"
                   class="px-4 py-2 rounded-full {{ $status === 'cancelled' ? 'bg-[#6A5B5B] text-white' : 'text-[#F1ECE6]' }}">
                    Dibatalkan
                </a>
            </div>
        </section>

        <section class="bg-[#4A4754] rounded-2xl soft-shadow overflow-hidden">
            <div class="grid grid-cols-[1.3fr,0.8fr,1fr,1fr] text-xs text-[#E6E1D8] px-6 py-4 border-b border-[#5B5663]">
                <div>Nama Barang</div>
                <div>Total Harga</div>
                <div>Status Konfirmasi</div>
                <div>Status Barang</div>
            </div>

            @forelse($transactions as $transaction)
                @php
                    $detail = $transaction->details->first();
                    $product = $detail?->product;
                    $confirmLabel = $transaction->payment_status === 'paid' ? 'Sudah Dikonfirmasi' : 'Belum Dikonfirmasi';
                    $confirmClass = $transaction->payment_status === 'paid' ? 'text-green-400' : 'text-red-400';
                    $statusBarang = $transaction->status === 'cancelled'
                        ? 'Dibatalkan'
                        : match($transaction->shipping_status) {
                            'shipped' => 'Dikirim',
                            'delivered' => 'Selesai',
                            default => 'Sedang Diproses'
                        };
                @endphp
                <a href="{{ route('staff.orders.edit', $transaction) }}" class="grid grid-cols-[1.3fr,0.8fr,1fr,1fr] items-center px-6 py-4 border-b border-[#5B5663] bg-[#8B7B7B]/30 hover:bg-[#8B7B7B]/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-[#2F2D36] overflow-hidden flex items-center justify-center">
                            @if($product && $product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-[10px] text-[#B8B2A9]">NO IMAGE</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-sm text-white">{{ $product?->name ?? 'Produk' }}</span>
                            <span class="block text-[10px] text-[#C9C3BA]">ID: {{ $transaction->invoice_code }}</span>
                        </div>
                    </div>
                    <div class="text-sm text-white">Rp {{ number_format($transaction->total_amount ?? 0, 0, ',', '.') }}</div>
                    <div class="text-sm {{ $confirmClass }}">{{ $confirmLabel }}</div>
                    <div class="text-sm text-white">{{ $statusBarang }}</div>
                </a>
            @empty
                <div class="px-6 py-8 text-center text-sm text-[#C9C3BA]">
                    Belum ada pesanan.
                </div>
            @endforelse
        </section>
    </div>
@endsection
