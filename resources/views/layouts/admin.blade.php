{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ephemeralbook - Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #3C3A44; color: #E8E5DF; }
        .soft-shadow { box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35); }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <header class="bg-[#D9D9D9] text-[#37353E] border-b border-zinc-300 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-8 py-5 flex items-center justify-between">
            <div class="flex items-center gap-x-3">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold tracking-tighter">Ephemeralbook</a>
            </div>

            <nav class="hidden md:flex items-center gap-x-10 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#876C67] transition-colors">Home</a>
                <a href="{{ route('admin.reports.sales') }}" class="hover:text-[#876C67] transition-colors">Report</a>
                <a href="{{ route('admin.staff.index') }}" class="hover:text-[#876C67] transition-colors">Staff list</a>
                <a href="{{ route('admin.users.index') }}" class="hover:text-[#876C67] transition-colors">User list</a>
                <a href="{{ route('admin.backups.index') }}" class="hover:text-[#876C67] transition-colors">Backup</a>
            </nav>

            <div class="flex items-center gap-x-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-2xl font-semibold transition text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-[#2F2D36] py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-8 text-center text-[#C9C3BA] text-sm">
            © {{ date('Y') }} Ephemeralbook. All rights reserved. | Admin Panel
        </div>
    </footer>

</body>
</html>
