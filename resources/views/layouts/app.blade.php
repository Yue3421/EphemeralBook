{{-- resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ephemeralbook - @yield('title', 'Home')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }
        
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)), 
                            url('{{ asset('images/hero-image.jpeg') }}');
            background-size: cover;
            background-position: center;
        }

        .tail-container {
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-200">

    {{-- NAVBAR --}}
    <nav class="bg-zinc-100 text-zinc-950 border-b border-zinc-200">
        <div class="tail-container px-8 py-5 flex items-center justify-between">
            <div class="flex items-center gap-x-3">
                <span class="text-3xl font-bold tracking-tighter">Ephemeralbook</span>
            </div>
            
            <div class="hidden md:flex items-center gap-x-10 text-sm font-medium">
                <a href="#" class="hover:text-amber-700 transition-colors">Home</a>
                <a href="#" class="hover:text-amber-700 transition-colors">Product</a>
                <a href="#" class="hover:text-amber-700 transition-colors">Purchase</a>
            </div>

            <div class="flex items-center gap-x-6">
                <button class="relative hover:text-amber-700 transition-colors">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                </button>
                <button class="hover:text-amber-700 transition-colors">
                    <i class="fa-solid fa-circle-user text-3xl"></i>
                </button>

                {{-- Logout di sebelah kanan --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <a href="#" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center gap-x-1.5 text-sm font-medium hover:text-amber-700 transition-colors">
                    <i class="fa-solid fa-right-from-bracket text-lg"></i>
                    Logout
                </a>
            </div>
        </div>
    </nav>

    @yield('content')

    {{-- FOOTER --}}
    <footer class="bg-zinc-100 text-zinc-950 py-16">
        <div class="tail-container px-8">
            <div class="flex flex-col md:flex-row justify-between items-start gap-y-12">
                <div>
                    <div class="flex items-center gap-x-4">
                        <div class="bg-zinc-900 text-white w-16 h-16 rounded-2xl flex items-center justify-center text-5xl font-black">EB</div>
                        <span class="text-3xl font-bold tracking-tight">EphemeralBook</span>
                    </div>
                    
                    <div class="mt-10 space-y-3 text-sm">
                        <p class="font-medium">Kontak kami :</p>
                        <p><i class="fa-brands fa-whatsapp mr-2"></i> WhatsApp : +62 000-0000-0000</p>
                        <p><i class="fa-brands fa-instagram mr-2"></i> Instagram : @EphemeralBook</p>
                        <p><i class="fa-solid fa-envelope mr-2"></i> Email : ephemeralbook@gmail.com</p>
                    </div>
                </div>

                <div class="text-right text-xs text-zinc-500 self-end">
                    COPYRIGHT © Yue3421 on GitHub
                </div>
            </div>
        </div>
    </footer>

</body>
</html>