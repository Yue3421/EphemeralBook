<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ephemeralbook - Staff')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #111827; color: white; }
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
<header class="bg-gray-200 text-black py-4 sticky top-0 z-50 shadow">
    <div class="max-w-7xl mx-auto px-8 flex justify-between items-center">
        <h1 class="text-xl font-bold tracking-tight">Ephemeralbook</h1>
        
        <nav class="flex items-center gap-x-8 text-base font-medium">
            <a href="{{ route('staff.dashboard') }}" class="hover:text-gray-700">Home</a>
            
            <a href="{{ route('staff.products.index') }}" class="hover:text-gray-700">Product</a>
            
            <a href="{{ route('staff.shipping.index') }}" class="hover:text-gray-700">Order List</a>
            
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-2xl font-semibold transition text-sm">
                    Logout
                </button>
            </form>
        </nav>
    </div>
</header>

    <!-- MAIN CONTENT -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-8 text-center text-gray-400 text-sm">
            © {{ date('Y') }} Ephemeralbook. All rights reserved. | Staff Panel
        </div>
    </footer>

</body>
</html>