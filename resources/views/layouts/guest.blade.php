<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Informasi Bansos Desa | Portal Bansos</title>

    <meta name="description"
        content="Portal Bansos adalah sistem informasi bantuan sosial desa untuk mengelola data penerima bantuan, penyaluran, dan transparansi informasi kepada masyarakat.">

    <meta name="keywords"
        content="bansos, bantuan sosial, portal bansos, PKH, BLT, BPNT, desa, penerima bantuan, penyaluran bansos">

    <meta name="author" content="Portal Bansos">

    <meta name="robots" content="index,follow">

    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:title" content="Portal Bansos">
    <meta property="og:description" content="Sistem Informasi Bantuan Sosial Desa">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
    <body class="bg-slate-50 font-sans antialiased text-slate-900 min-h-screen flex items-center justify-center p-4">

        {{-- Bingkai Card Utama Premium (Berlaku untuk semua halaman Guest) --}}
        <div class="w-full max-w-md p-6 sm:p-8 bg-white rounded-2xl border border-slate-100 shadow-xl shadow-slate-200/50">
            
            {{-- Isi form halaman seperti Login/Register akan otomatis masuk ke slot ini --}}
            {{ $slot }}
            
        </div>

    </body>
</html>