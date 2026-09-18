<!DOCTYPE html>
<html lang="id" class="bg-gray-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Adibah Shop' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#070220">
    <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    @livewireStyles
    <style>
        @media print {

            aside,
            header,
            nav,
            .no-print {
                display: none !important;
            }

            main {
                padding: 0 !important;
            }

            body {
                background: white !important;
            }

            .print-item {
                border: 1px solid #ddd;
                page-break-inside: avoid;
            }
        }
    </style>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-100 text-gray-800">
    <div x-data="{ sidebarOpen: false }">

        @php
        $linkBase = 'flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition';
        $linkIdle = 'text-gray-300 hover:bg-gray-800 hover:text-white';
        $linkActive = 'bg-gray-800 text-white';
        @endphp

        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-gray-900 text-gray-100 transform transition-transform duration-200 md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="h-16 flex items-center gap-2 px-4 border-b border-gray-800">
                <img src="{{ asset('images/logo-adibah.png') }}" alt="Adibah Shop" class="h-10 w-auto">
                <span class="font-bold text-base">Adibah Shop</span>
            </div>
            <nav class="p-4 space-y-1">
                <a href="/dashboard" wire:navigate x-on:click="sidebarOpen = false"
                    class="{{ $linkBase }} {{ request()->is('dashboard') ? $linkActive : $linkIdle }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Dashboard
                </a>

                <a href="/kasir" wire:navigate
                    class="{{ $linkBase }} {{ request()->is('kasir') ? $linkActive : $linkIdle }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="9" cy="20" r="1.4" />
                        <circle cx="18" cy="20" r="1.4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 3h2l2.5 12h11l2-8H6" />
                    </svg>
                    Kasir
                </a>

                @if (auth()->user()->isAdmin())
                <a href="/barang" wire:navigate
                    class="{{ $linkBase }} {{ request()->is('barang') ? $linkActive : $linkIdle }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4v10l-9 4-9-4V7z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 4 9-4M12 11v10" />
                    </svg>
                    Barang
                </a>

                <a href="/stok-masuk" wire:navigate
                    class="{{ $linkBase }} {{ request()->is('stok-masuk') ? $linkActive : $linkIdle }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Stok Masuk
                </a>

                <a href="/kategori" wire:navigate
                    class="{{ $linkBase }} {{ request()->is('kategori') ? $linkActive : $linkIdle }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12V5a2 2 0 0 1 2-2h7l9 9-9 9-9-9z" />
                        <circle cx="7.5" cy="7.5" r="1.3" />
                    </svg>
                    Kategori
                </a>

                <a href="/cetak-barcode" wire:navigate x-on:click="sidebarOpen = false"
                    class="{{ $linkBase }} {{ request()->is('cetak-barcode') ? $linkActive : $linkIdle }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h1v14H4zM7 5h1v14H7zM10 5h2v14h-2zM14 5h1v14h-1zM17 5h1v14h-1zM20 5h.5v14H20z" />
                    </svg>
                    Cetak Barcode
                </a>

                <a href="/riwayat" wire:navigate
                    class="{{ $linkBase }} {{ request()->is('riwayat') ? $linkActive : $linkIdle }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                    </svg>
                    Riwayat
                </a>

                <a href="/laporan" wire:navigate
                    class="{{ $linkBase }} {{ request()->is('laporan') ? $linkActive : $linkIdle }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M8 16v-5M13 16V8M18 16v-9" />
                    </svg>
                    Laporan
                </a>

                <a href="/user" wire:navigate x-on:click="sidebarOpen = false"
                    class="{{ $linkBase }} {{ request()->is('user') ? $linkActive : $linkIdle }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87m6-1.13a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm6 0a4 4 0 1 0-1-7.87" />
                    </svg>
                    Manajemen User
                </a>
                @endif
            </nav>
        </aside>

        {{-- Overlay gelap saat sidebar terbuka di HP --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-30 md:hidden"></div>

        {{-- Area konten --}}
        <div class="md:ml-64">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 sticky top-0 z-20">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex-1"></div>
                @auth
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">
                        {{ auth()->user()->name }}
                        <span class="text-xs text-gray-400">({{ auth()->user()->role }})</span>
                    </span>
                    <a href="/logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="text-sm text-red-600 hover:underline">Logout</a>
                    <form id="logout-form" action="/logout" method="POST" class="hidden">@csrf</form>
                </div>
                @endauth
            </header>

            <main class="p-6">
                {{ $slot }}
            </main>
        </div>

        {{-- Wadah notifikasi toast --}}
        <div x-data="{
            toasts: [],
            add(e) {
                const id = Date.now() + Math.random();
                this.toasts.push({ id, message: e.message, type: e.type || 'success' });
                setTimeout(() => this.remove(id), 3500);
            },
            remove(id) { this.toasts = this.toasts.filter(t => t.id !== id); }
        }"
            x-on:toast.window="add($event.detail)"
            class="fixed top-5 right-5 z-[100] w-80 space-y-2">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-8"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="flex items-start gap-3 p-4 rounded-lg shadow-lg text-white"
                    :class="{
                    'bg-green-600': toast.type === 'success',
                    'bg-red-600': toast.type === 'error',
                    'bg-blue-600': toast.type === 'info'
                 }">
                    <span class="flex-1 text-sm" x-text="toast.message"></span>
                    <button x-on:click="remove(toast.id)" class="text-white/70 hover:text-white">✕</button>
                </div>
            </template>
        </div>

    </div>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>

    @livewireScripts
</body>

</html>