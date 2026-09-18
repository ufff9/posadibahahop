<div class="max-w-5xl mx-auto p-6" x-data="{ open: false }"
    x-on:transaksi-selesai.window="open = false">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Kasir</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Kiri: cari barang --}}
        <div class="bg-white p-4 rounded-lg shadow h-fit">
            {{-- Scanner barcode (Alpine + ZXing) --}}
            <div x-data="scannerBarcode()" class="mb-4">
                <button type="button" x-on:click="toggle()"
                    class="w-full flex items-center justify-center gap-2 py-2 rounded text-sm font-medium"
                    :class="aktif ? 'bg-red-100 text-red-700' : 'bg-blue-600 text-white hover:bg-blue-700'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7V5a2 2 0 0 1 2-2h2M17 3h2a2 2 0 0 1 2 2v2M21 17v2a2 2 0 0 1-2 2h-2M7 21H5a2 2 0 0 1-2-2v-2M4 12h16" />
                    </svg>
                    <span x-text="aktif ? 'Tutup Kamera' : 'Scan Barcode'"></span>
                </button>

                <div x-show="aktif" x-cloak class="mt-3">
                    <div class="relative mx-auto rounded-lg overflow-hidden bg-black" style="max-width: 320px;">
                        <video id="reader-video" class="w-full block" style="height: 220px; object-fit: cover;"></video>
                        {{-- Bingkai panduan --}}
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="border-2 border-green-400 rounded-lg"
                                style="width: 80%; height: 90px; box-shadow: 0 0 0 9999px rgba(0,0,0,0.45);"></div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 text-center">Posisikan barcode di dalam kotak hijau</p>
                </div>
            </div>

            <label class="block text-sm mb-1">Cari barang (nama / kode)</label>
            <input type="text" wire:model.live="cari" placeholder="Ketik untuk mencari..."
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">

            @if ($hasilCari->count() > 0)
            <div class="mt-2 divide-y border rounded">
                @foreach ($hasilCari as $barang)
                <button type="button" wire:click="tambahKeKeranjang({{ $barang->id }})"
                    class="w-full text-left px-3 py-2 hover:bg-blue-50 flex items-center gap-3">
                    @if ($barang->foto)
                    <img src="{{ asset('storage/' . $barang->foto) }}"
                        class="w-10 h-10 object-cover rounded shrink-0">
                    @else
                    <div class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center text-gray-300 text-xs shrink-0">
                        N/A
                    </div>
                    @endif
                    <span class="flex-1">
                        <span class="block text-sm">{{ $barang->nama }}
                            <span class="text-gray-400 text-xs">({{ $barang->kode }})</span>
                        </span>
                        <span class="block text-gray-600 text-xs">
                            Rp {{ number_format($barang->harga, 0, ',', '.') }} · stok {{ $barang->stok }}
                        </span>
                    </span>
                </button>
                @endforeach
            </div>
            @elseif (strlen($cari) >= 1)
            <p class="mt-2 text-sm text-gray-400">Barang tidak ditemukan.</p>
            @endif
        </div>

        {{-- Kanan: keranjang --}}
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="font-bold mb-3">Keranjang</h2>

            @forelse ($keranjang as $id => $item)
            <div class="flex items-center justify-between py-2 border-b">
                @if (!empty($item['foto']))
                <img src="{{ asset('storage/' . $item['foto']) }}"
                    class="w-10 h-10 object-cover rounded shrink-0 mr-3">
                @else
                <div class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center text-gray-300 text-xs shrink-0 mr-3">
                    N/A
                </div>
                @endif
                <div class="flex-1">
                    <div class="text-sm font-medium">{{ $item['nama'] }}</div>
                    <div class="text-xs text-gray-500">Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click="kurangiJumlah({{ $id }})"
                        class="w-7 h-7 rounded bg-gray-200 hover:bg-gray-300">−</button>
                    <span class="w-8 text-center">{{ $item['jumlah'] }}</span>
                    <button wire:click="tambahJumlah({{ $id }})"
                        class="w-7 h-7 rounded bg-gray-200 hover:bg-gray-300">+</button>
                </div>
                <div class="w-20 text-right text-sm">
                    Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}
                </div>
                <button wire:click="hapusDariKeranjang({{ $id }})"
                    class="ml-2 text-red-500 hover:text-red-700">✕</button>
            </div>
            @empty
            <p class="text-sm text-gray-400 py-4 text-center">Keranjang masih kosong.</p>
            @endforelse

            <div class="flex justify-between items-center mt-4 pt-3 border-t">
                <span class="font-bold">Total</span>
                <span class="font-bold text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <button type="button" x-on:click="open = true"
                @disabled(count($keranjang)===0)
                class="w-full mt-4 bg-green-600 text-white py-2 rounded hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed">
                Bayar
            </button>

            @if ($transaksiTerakhirId)
            <a href="/struk/{{ $transaksiTerakhirId }}" target="_blank"
                class="block w-full text-center mt-2 border border-blue-600 text-blue-600 py-2 rounded hover:bg-blue-50 text-sm">
                🧾 Cetak Struk Terakhir
            </a>
            @endif
        </div>
    </div>

    {{-- Modal pembayaran (dikendalikan Alpine) --}}
    <div x-show="open" x-cloak
        class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50"
        x-on:click.self="open = false">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-bold mb-4">Pembayaran</h2>

            <div class="flex justify-between mb-4">
                <span>Total belanja</span>
                <span class="font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            {{-- Pilihan metode bayar --}}
            <label class="block text-sm mb-1">Metode Pembayaran</label>
            <div class="grid grid-cols-3 gap-2 mb-4">
                @foreach (['tunai' => 'Tunai', 'qris' => 'QRIS', 'transfer' => 'Transfer'] as $nilai => $label)
                <button type="button" wire:click="$set('metodeBayar', '{{ $nilai }}')"
                    class="py-2 rounded border text-sm
                                {{ $metodeBayar === $nilai
                                    ? 'bg-blue-600 text-white border-blue-600'
                                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                    {{ $label }}
                </button>
                @endforeach
            </div>

            {{-- Uang dibayar hanya relevan untuk tunai --}}
            @if ($metodeBayar === 'tunai')
            <label class="block text-sm mb-1">Uang dibayar</label>
            <input type="number" wire:model.live="bayar"
                class="w-full border rounded px-3 py-2 mb-1 focus:outline-none focus:ring focus:border-green-400">
            @error('bayar') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

            <div class="flex justify-between mt-3 mb-5">
                <span>Kembalian</span>
                <span class="font-bold text-green-700">Rp {{ number_format($kembalian, 0, ',', '.') }}</span>
            </div>
            @else
            <div class="bg-blue-50 text-blue-700 text-sm rounded p-3 mb-5 text-center">
                Pembayaran {{ strtoupper($metodeBayar) }} sebesar
                <span class="font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            @endif

            <div class="flex gap-2">
                <button type="button" x-on:click="open = false"
                    class="flex-1 bg-gray-200 text-gray-700 py-2 rounded hover:bg-gray-300">Batal</button>
                <button type="button" wire:click="proses"
                    class="flex-1 bg-green-600 text-white py-2 rounded hover:bg-green-700">Proses</button>
            </div>
        </div>
    </div>
</div>

@script
<script>
    // Muat library ZXing dari CDN sekali saja
    if (!window.ZXing) {
        const s = document.createElement('script');
        s.src = 'https://unpkg.com/@zxing/library@0.21.3/umd/index.min.js';
        document.head.appendChild(s);
    }

    window.scannerBarcode = function() {
        return {
            aktif: false,
            reader: null,
            toggle() {
                this.aktif ? this.stop() : this.start();
            },
            start() {
                if (!window.ZXing) {
                    alert('Library barcode belum termuat, tunggu sebentar lalu coba lagi.');
                    return;
                }
                this.aktif = true;
                this.$nextTick(() => {
                    const constraints = {
                        video: {
                            facingMode: 'environment',
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            },
                            frameRate: {
                                ideal: 30
                            }
                        }
                    };

                    const hints = new Map();
                    hints.set(ZXing.DecodeHintType.POSSIBLE_FORMATS, [
                        ZXing.BarcodeFormat.EAN_13,
                        ZXing.BarcodeFormat.EAN_8,
                        ZXing.BarcodeFormat.UPC_A,
                        ZXing.BarcodeFormat.UPC_E,
                        ZXing.BarcodeFormat.CODE_128,
                        ZXing.BarcodeFormat.CODE_39,
                    ]);
                    hints.set(ZXing.DecodeHintType.TRY_HARDER, true);

                    this.reader = new ZXing.BrowserMultiFormatReader(hints);

                    this.reader.decodeFromConstraints(
                        constraints,
                        'reader-video',
                        (result, err) => {
                            if (result) {
                                const kode = result.getText();
                                this.$wire.scanBarcode(kode);
                                this.reader.reset();
                                this.aktif = false;
                                setTimeout(() => {
                                    this.start();
                                }, 800);
                            }
                        }
                    ).catch((e) => {
                        this.aktif = false;
                        alert('Tidak bisa membuka kamera: ' + e);
                    });
                });
            },
            stop() {
                if (this.reader) {
                    this.reader.reset();
                    this.reader = null;
                }
                this.aktif = false;
            }
        };
    };
</script>
@endscript