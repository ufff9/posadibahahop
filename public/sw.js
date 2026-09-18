const CACHE_NAME = 'pos-toko-v1';

// Saat service worker dipasang
self.addEventListener('install', (event) => {
    self.skipWaiting();
});

// Saat diaktifkan — bersihkan cache lama
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((names) =>
            Promise.all(
                names.filter((n) => n !== CACHE_NAME).map((n) => caches.delete(n))
            )
        )
    );
    self.clients.claim();
});

// Saat ada permintaan — ambil dari jaringan seperti biasa
self.addEventListener('fetch', (event) => {
    event.respondWith(
        fetch(event.request).catch(() => caches.match(event.request))
    );
});