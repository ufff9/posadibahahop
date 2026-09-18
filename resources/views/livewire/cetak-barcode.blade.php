<div class="p-6">
    <div class="flex items-center justify-between mb-6 no-print">
        <h1 class="text-2xl font-bold text-gray-800">Cetak Barcode</h1>
        <button onclick="window.print()"
            class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6v-8z" />
            </svg>
            Cetak Semua
        </button>
    </div>

    <div class="mb-4 no-print">
        <input type="text" wire:model.live="cari" placeholder="Cari barang untuk dicetak barcode-nya..."
            class="w-full max-w-sm border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="area-barcode">
        @forelse ($barangs as $barang)
        <div class="bg-white border rounded-lg p-3 text-center print-item">
            <div class="text-xs font-medium text-gray-700 mb-1 truncate">{{ $barang->nama }}</div>
            <svg class="barcode w-full" data-kode="{{ $barang->kode }}"></svg>
            <div class="text-xs text-gray-500 mt-1">Rp {{ number_format($barang->harga, 0, ',', '.') }}</div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-lg shadow p-6 text-center text-gray-400">
            Tidak ada barang.
        </div>
        @endforelse
    </div>
</div>

@script
<script>
    // Muat JsBarcode dari CDN
    if (!window.JsBarcode) {
        const s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js';
        document.head.appendChild(s);
    }

    // Fungsi menggambar semua barcode di halaman
    window.gambarSemuaBarcode = function() {
        if (!window.JsBarcode) {
            setTimeout(window.gambarSemuaBarcode, 100); // tunggu library termuat
            return;
        }
        document.querySelectorAll('svg.barcode').forEach((el) => {
            const kode = el.getAttribute('data-kode');
            try {
                JsBarcode(el, kode, {
                    format: 'CODE128',
                    width: 1.5,
                    height: 45,
                    fontSize: 12,
                    margin: 4,
                });
            } catch (e) {
                // kode tidak valid untuk barcode, lewati
            }
        });
    };

    // Gambar saat halaman dimuat
    window.gambarSemuaBarcode();

    // Gambar ulang tiap kali Livewire memperbarui (misalnya setelah mencari)
    Livewire.hook('morph.updated', () => {
        window.gambarSemuaBarcode();
    });
</script>
@endscript