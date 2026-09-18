<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Adibah Shop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-900 text-white flex items-center justify-center">
    <div class="text-center px-6">
        <img src="{{ asset('images/logo-adibah.png') }}" alt="Adibah Shop"
            class="w-32 h-auto mx-auto mb-6 rounded-2xl">

        <h1 class="text-3xl font-bold mb-3">Adibah Shop</h1>
        <p class="text-gray-400 mb-8 max-w-md mx-auto">
            Sistem kasir toko ritel dengan manajemen stok real-time.
        </p>

        <a href="/login" wire:navigate
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium transition">
            Masuk ke Aplikasi
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6" />
            </svg>
        </a>

        <p class="text-gray-600 text-sm mt-10">
            &copy; {{ date('Y') }} POS Toko
        </p>
    </div>
</body>

</html>