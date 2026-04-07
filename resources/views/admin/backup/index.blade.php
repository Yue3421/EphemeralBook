{{-- resources/views/admin/backup/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Backup')
@section('content')
    <div class="max-w-7xl mx-auto px-8 py-12">
        @php
            $latest = $backups->first();
        @endphp

        <section class="text-center mb-6">
            <p class="text-sm text-[#E6E1D8]">
                Terakhir DiBackup tanggal
                <span class="font-semibold">
                    {{ $latest?->created_at?->format('H:i d/m/Y') ?? '-' }}
                </span>
            </p>
        </section>

        <section class="flex items-center justify-center gap-4 mb-8">
            <form method="POST" action="{{ route('admin.backups.create') }}">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 transition-colors px-8 py-3 rounded-xl text-white font-semibold">
                    BACKUP
                </button>
            </form>
            <a href="{{ route('admin.backups.restoreForm') }}" class="bg-green-600 hover:bg-green-700 transition-colors px-8 py-3 rounded-xl text-white font-semibold">
                RESTORE
            </a>
        </section>

        <section class="bg-[#6E5A5A] rounded-2xl soft-shadow overflow-hidden">
            <div class="px-6 py-4 text-sm font-semibold text-white border-b border-[#7A6A6A]">
                Riwayat Backup
            </div>
            <div class="grid grid-cols-[1.5fr,0.7fr,1fr,0.6fr] text-xs text-[#E6E1D8] px-6 py-3 border-b border-[#7A6A6A]">
                <div>Nama Lengkap</div>
                <div>File Size</div>
                <div>Backup Terakhir</div>
                <div>Download</div>
            </div>

            @forelse($backups as $backup)
                <div class="grid grid-cols-[1.5fr,0.7fr,1fr,0.6fr] items-center px-6 py-3 text-sm text-white border-b border-[#7A6A6A] bg-[#8B7B7B]/40">
                    <div>{{ $backup->creator?->name ?? 'Admin' }}</div>
                    <div>{{ $backup->formatted_size }}</div>
                    <div>{{ $backup->created_at?->format('H:i d/m/Y') }}</div>
                    <div>
                        <a href="{{ route('admin.backups.download', $backup) }}" class="text-blue-200 hover:text-blue-300 underline">
                            Download
                        </a>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-[#E6E1D8]">
                    Belum ada backup.
                </div>
            @endforelse
        </section>
    </div>
@endsection
