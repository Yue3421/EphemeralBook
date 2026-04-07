<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi | EphemeralBook</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #3C3A44;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .split-container {
            display: flex;
            width: 100%;
            max-width: 1100px;
            background-color: #44444E;
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(113, 90, 90, 0.3);
        }
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #3C3A44 0%, #44444E 100%);
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            border-right: 1px solid rgba(113, 90, 90, 0.3);
        }
        .right-panel {
            flex: 1;
            background-color: #44444E;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .book-icon {
            width: 80px;
            height: 80px;
            background-color: #D3DAD9;
            border-radius: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            border: 2px solid #715A5A;
            transform: rotate(-3deg);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }
        .input-field {
            background-color: #3C3A44;
            border: 1px solid rgba(113, 90, 90, 0.3);
            color: #D3DAD9;
            border-radius: 1rem;
            padding: 0.75rem 1rem;
            width: 100%;
            transition: all 0.3s;
        }
        .input-field:focus {
            outline: none;
            border-color: #715A5A;
            box-shadow: 0 0 0 3px rgba(113, 90, 90, 0.2);
        }
        .input-field::placeholder {
            color: #D3DAD9;
            opacity: 0.3;
        }
        .btn-login {
            background-color: #715A5A;
            color: #D3DAD9;
            border-radius: 1rem;
            padding: 0.75rem;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-login:hover {
            background-color: #5f4a4a;
            transform: scale(1.02);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }
        .floating-shape {
            position: absolute;
            width: 150px;
            height: 150px;
            background-color: rgba(113, 90, 90, 0.1);
            border-radius: 50%;
            bottom: -30px;
            right: -30px;
            z-index: 0;
        }
        .floating-shape-2 {
            position: absolute;
            width: 100px;
            height: 100px;
            background-color: rgba(113, 90, 90, 0.1);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            top: -20px;
            left: -20px;
            z-index: 0;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
    </style>
</head>
<body>
    
    <div class="split-container mx-4">
        <!-- Left Panel - Branding & Welcome -->
        <div class="left-panel relative overflow-hidden">
            <div class="floating-shape"></div>
            <div class="floating-shape-2"></div>
            
            <div class="relative z-10 animate-fade-in">
                <!-- Logo Container -->
                <div class="w-40 h-40 bg-[#D3DAD9] rounded-2xl shadow-lg flex items-center justify-center transform border-2 border-[#715A5A] overflow-hidden mb-6">
                    <img src="{{ asset('images/logo-ephemeral.png') }}" alt="EphemeralBook Logo" class="w-full h-full object-contain p-3">
                </div>
                
                <!-- Brand Name -->
                <h1 class="text-5xl font-bold text-[#D3DAD9] mb-4 leading-tight">
                    Ephemeral<br>Book
                </h1>
                
                <!-- Welcome Message -->
                <p class="text-xl text-[#D3DAD9] text-opacity-80 mb-8 leading-relaxed">
                    Selamat datang di EphemeralBook, tempat terbaik untuk mencari buku Secondhand berkualitas.
                </p>
                
                <!-- Feature Highlights -->
                <div class="space-y-4 mt-6">
                    <div class="flex items-center space-x-3 text-[#D3DAD9] text-opacity-70">
                        <div class="w-8 h-8 bg-[#715A5A] rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-sm text-[#D3DAD9]"></i>
                        </div>
                        <span>Ribuan koleksi buku bekas berkualitas</span>
                    </div>
                    <div class="flex items-center space-x-3 text-[#D3DAD9] text-opacity-70">
                        <div class="w-8 h-8 bg-[#715A5A] rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-sm text-[#D3DAD9]"></i>
                        </div>
                        <span>Harga terjangkau dan ramah di kantong</span>
                    </div>
                    <div class="flex items-center space-x-3 text-[#D3DAD9] text-opacity-70">
                        <div class="w-8 h-8 bg-[#715A5A] rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-sm text-[#D3DAD9]"></i>
                        </div>
                        <span>Pengiriman cepat ke seluruh Indonesia</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Panel - Register Form -->
        <div class="right-panel">
            <div class="max-w-md mx-auto w-full">
                <div class="text-center mb-8 animate-fade-in delay-1">
                    <h2 class="text-3xl font-bold text-[#D3DAD9]">Registrasi</h2>
                    <p class="text-[#D3DAD9] text-opacity-60 mt-2">Daftarkan akun kamu untuk mulai berbelanja</p>
                </div>
                
                <!-- Session Status -->
                @if(session('error'))
                    <div class="mb-6 bg-[#715A5A] bg-opacity-20 border-l-4 border-[#715A5A] text-[#D3DAD9] p-4 rounded-lg flex items-center animate-fade-in delay-1" role="alert">
                        <i class="fas fa-exclamation-circle mr-3 text-[#715A5A]"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="mb-6 bg-[#715A5A] bg-opacity-20 border-l-4 border-[#715A5A] text-[#D3DAD9] p-4 rounded-lg flex items-center animate-fade-in delay-1" role="alert">
                        <i class="fas fa-check-circle mr-3 text-[#715A5A]"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                
                <!-- Error Validation -->
                @if($errors->any())
                    <div class="mb-6 bg-[#715A5A] bg-opacity-20 border-l-4 border-[#715A5A] text-[#D3DAD9] p-4 rounded-lg animate-fade-in delay-1">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle mr-2 text-[#715A5A]"></i>
                            <span class="font-semibold">Terdapat kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside ml-6 space-y-1 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Form Register -->
                <form method="POST" action="{{ route('register') }}" class="space-y-5 animate-fade-in delay-2">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-[#D3DAD9] mb-2">
                            <i class="fas fa-user mr-2 text-[#715A5A]"></i>
                            Nama
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name') }}"
                            class="input-field"
                            placeholder="Nama lengkap"
                            required
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[#D3DAD9] mb-2">
                            <i class="fas fa-envelope mr-2 text-[#715A5A]"></i>
                            Email
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}"
                            class="input-field"
                            placeholder="nama@email.com"
                            required
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[#D3DAD9] mb-2">
                            <i class="fas fa-lock mr-2 text-[#715A5A]"></i>
                            Sandi
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="input-field"
                            placeholder="********"
                            required
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[#D3DAD9] mb-2">
                            <i class="fas fa-lock mr-2 text-[#715A5A]"></i>
                            Konfirmasi Sandi
                        </label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            class="input-field"
                            placeholder="********"
                            required
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[#D3DAD9] mb-2">
                            <i class="fas fa-phone mr-2 text-[#715A5A]"></i>
                            Nomor HP (opsional)
                        </label>
                        <input 
                            type="text" 
                            name="phone" 
                            id="phone" 
                            value="{{ old('phone') }}"
                            class="input-field"
                            placeholder="08xxxxxxxxxx"
                        >
                    </div>
                    
                    <button type="submit" class="btn-login mt-6">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar
                    </button>
                    
                    <div class="text-center mt-4">
                        <p class="text-[#D3DAD9] text-opacity-70">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-semibold text-[#715A5A] hover:text-opacity-80 transition-colors hover:underline">
                                Masuk sekarang
                            </a>
                        </p>
                    </div>
                </form>
                
                <div class="text-center mt-8 text-[#D3DAD9] text-opacity-40 text-xs animate-fade-in delay-3">
                    <p>&copy; {{ date('Y') }} EphemeralBook. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
