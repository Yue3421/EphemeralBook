{{-- resources/views/contact.blade.php --}}
@extends('layouts.app')
@section('title', 'Kontak Kami')
@section('content')
    <style>
        body {
            background-color: #37353E;
            color: #E8E5DF;
        }
        .soft-shadow {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }
        .contact-card {
            transition: transform 0.2s ease, background-color 0.2s ease;
        }
        .contact-card:hover {
            transform: scale(1.02);
        }
    </style>

    <div class="tail-container px-8 py-40">
        <section class="text-center mb-10">
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-[#DCD7D1]">kontak kami</h1>
        </section>

        <section class="flex justify-center">
            <div class="w-full max-w-4xl">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <a href="https://wa.me/6285117824604"
                    target="_blank"
                    rel="noopener"
                    class="contact-card bg-[#876C67] rounded-2xl p-10 text-center soft-shadow transition-colors">
                        <p class="text-sm font-semibold text-white mb-4">WhatsApp</p>
                        <p class="text-sm text-white/90">+62 851-1782-4604</p>
                    </a>
                    <a href="https://instagram.com/EphemeralBook"
                    target="_blank"
                    rel="noopener"
                    class="contact-card bg-[#876C67] rounded-2xl p-10 text-center soft-shadow transition-colors">
                        <p class="text-sm font-semibold text-white mb-4">Instagram</p>
                        <p class="text-sm text-white/90">@EphemeralBook</p>
                    </a>
                    <a href="mailto:ephemeralbook@gmail.com"
                    class="contact-card bg-[#876C67] rounded-2xl p-10 text-center soft-shadow transition-colors">
                        <p class="text-sm font-semibold text-white mb-4">Email</p>
                        <p class="text-sm text-white/90">ephemeralbook@gmail.com</p>
                    </a>
                </div>

                <p class="text-center text-sm text-[#E6E1D8] mt-10">
                    Jika anda memiliki keluhan silahkan kontak ke salah satu media sosial kami
                </p>
            </div>
        </section>
    </div>
@endsection
