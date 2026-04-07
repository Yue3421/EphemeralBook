{{-- resources/views/admin/backup/restore.blade.php --}}
@extends('layouts.admin')
@section('title', 'Restore')
@section('content')
    <div class="max-w-4xl mx-auto px-8 py-16">
        <section class="text-center mb-8">
            <h1 class="text-2xl md:text-3xl font-semibold text-[#DCD7D1]">RESTORE</h1>
        </section>

        <section class="flex justify-center">
            <div class="w-full max-w-xl bg-[#6E5A5A] rounded-2xl p-6 soft-shadow">
                <form action="{{ route('admin.backups.restore') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex items-center gap-3">
                        <select name="backup_id" class="w-full bg-[#D9D9D9] text-zinc-900 text-sm rounded-lg px-4 py-2" required>
                            <option value="">Pilih File</option>
                            @foreach($backups as $backup)
                                <option value="{{ $backup->id }}">
                                    {{ $backup->file_name }} ({{ $backup->formatted_size }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <label class="flex items-center gap-2 text-xs text-white">
                        <input type="checkbox" name="confirm" value="1" required class="accent-green-600">
                        Saya tau apa yang saya lakukan dan akan bertanggung jawab
                    </label>

                    <button type="submit" class="bg-green-600 hover:bg-green-700 transition-colors px-5 py-2 rounded-lg text-xs text-white font-semibold">
                        Konfirmasi Restore
                    </button>
                </form>
            </div>
        </section>
    </div>
@endsection
