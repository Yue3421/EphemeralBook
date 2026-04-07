<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ephemeralbook - Staff')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #3C3A44; color: #E8E5DF; }
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 20px -5px rgb(0 0 0 / 0.35);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- NAVBAR -->
<header class="bg-[#D9D9D9] text-black border-b border-zinc-300 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-8 py-5 flex items-center justify-between">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('staff.dashboard') }}" class="text-2xl font-bold tracking-tighter">Ephemeralbook</a>
        </div>

        <nav class="hidden md:flex items-center gap-x-10 text-sm font-medium">
            <a href="{{ route('staff.dashboard') }}" class="hover:text-amber-700 transition-colors">Home</a>
            <a href="{{ route('staff.products.index') }}" class="hover:text-amber-700 transition-colors">Product</a>
            <a href="{{ route('staff.orders.index') }}" class="hover:text-amber-700 transition-colors">Order List</a>
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

    <!-- MAIN CONTENT -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#2F2D36] py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-8 text-center text-[#C9C3BA] text-sm">
            © {{ date('Y') }} Ephemeralbook. All rights reserved. | Staff Panel
        </div>
    </footer>

</body>
</html>
