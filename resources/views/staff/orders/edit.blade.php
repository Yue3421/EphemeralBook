{{-- resources/views/staff/orders/edit.blade.php --}}
@extends('layouts.staff')
@section('title', 'Edit Order Status')
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

    @php
        $detail = $transaction->details->first();
        $product = $detail?->product;
    @endphp

    <div class="max-w-6xl mx-auto px-8 py-12">
        <section class="grid grid-cols-1 lg:grid-cols-[320px,1fr] gap-10 items-center">
            <div class="flex justify-center">
                <div class="w-72 h-72 rounded-2xl bg-[#2F2D36] overflow-hidden soft-shadow flex items-center justify-center">
                    @if($product && $product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-sm text-[#B8B2A9]">NO IMAGE</span>
                    @endif
                </div>
            </div>

            <div class="bg-[#4A4754] rounded-2xl p-8 soft-shadow">
                <h2 class="text-lg font-semibold text-white text-center mb-6">Detail Pesanan</h2>

                <div class="space-y-3 text-sm text-[#E6E1D8]">
                    <div class="flex items-center justify-between">
                        <span>Nama Barang</span>
                        <span class="text-white font-semibold">{{ $product?->name ?? 'Produk' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Harga (Total)</span>
                        <span class="text-white font-semibold">Rp {{ number_format($transaction->total_amount ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <span class="text-sm text-[#E6E1D8] font-semibold">STATUS KONFIRMASI</span>
                    <form action="{{ route('staff.orders.paymentStatus', $transaction) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center gap-2">
                            <select name="payment_status" class="bg-[#D9D9D9] text-zinc-900 text-xs rounded-lg px-4 py-2" {{ $transaction->status === 'cancelled' ? 'disabled' : '' }}>
                                <option value="unpaid" {{ $transaction->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Dikonfirmasi</option>
                                <option value="paid" {{ $transaction->payment_status === 'paid' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="failed" {{ $transaction->payment_status === 'failed' ? 'selected' : '' }}>Gagal</option>
                                <option value="refunded" {{ $transaction->payment_status === 'refunded' ? 'selected' : '' }}>Refund</option>
                            </select>
                            <button type="submit" class="bg-[#529A00] hover:bg-green-700 transition-colors px-4 py-2 rounded-lg text-xs text-white font-semibold" {{ $transaction->status === 'cancelled' ? 'disabled' : '' }}>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <span class="text-sm text-[#E6E1D8] font-semibold">STATUS BARANG</span>
                    <form action="{{ route('staff.orders.status', $transaction) }}" method="POST" class="flex flex-col gap-3 items-end">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center gap-2">
                            <select name="shipping_status" class="bg-[#D9D9D9] text-zinc-900 text-xs rounded-lg px-4 py-2" {{ $transaction->status === 'cancelled' ? 'disabled' : '' }}>
                                <option value="packing" {{ $transaction->shipping_status === 'packing' ? 'selected' : '' }}>Sedang Diproses</option>
                                <option value="shipped" {{ $transaction->shipping_status === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                <option value="delivered" {{ $transaction->shipping_status === 'delivered' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            <button type="submit" class="bg-[#529A00] hover:bg-green-700 transition-colors px-4 py-2 rounded-lg text-xs text-white font-semibold" {{ $transaction->status === 'cancelled' ? 'disabled' : '' }}>
                                Simpan
                            </button>
                        </div>
                        @if($transaction->shipping_status !== 'packing')
                        <input type="text"
                            name="tracking_number"
                            value="{{ $transaction->shipping?->tracking_number }}"
                            placeholder="Masukan resi paket"
                            class="w-[260px] bg-[#D9D9D9] border border-[#000000] rounded-lg px-3 py-2 text-xs text-zinc-900 focus:outline-none focus:ring-2 focus:ring-[#8B7B7B]"
                            {{ $transaction->status === 'cancelled' ? 'disabled' : '' }}>
                        @endif
                    </form>
                </div>

            </div>
        </section>

        <div class="mt-10 flex justify-end">
            <a href="{{ route('staff.orders.index') }}" class="bg-[#8B7B7B] hover:bg-[#7A6A6A] transition-colors px-4 py-2 rounded-lg text-xs text-white font-semibold">
                Kembali
            </a>
        </div>
    </div>
@endsection
