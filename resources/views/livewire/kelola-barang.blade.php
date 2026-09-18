<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Manajemen Barang</h1>

    {{-- FORM tambah / edit --}}
    <form wire:submit="simpan" class="mb-8 bg-white p-5 rounded-xl shadow grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div x-data="scannerKode()">
            <label class="block text-sm mb-1 text-gray-600">Kode Barang (barcode)</label>
            <div class="flex gap-2">
                <input type="text" wire:model="kode" placeholder="Ketik atau scan..."
                    class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                <button type="button" x-on:click="toggle()"
                    class="px-3 rounded text-sm font-medium whitespace-nowrap"
                    :class="aktif ? 'bg-red-100 text-red-700' : 'bg-blue-600 text-white hover:bg-blue-700'">
                    <span x-text="aktif ? 'Tutup' : '📷 Scan'"></span>
                </button>
            </div>
            @error('kode') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

            <div x-show="aktif" x-cloak class="mt-2">
                <video id="reader-kode" class="w-full rounded border bg-black" style="max-height:220px;"></video>
                <p class="text-xs text-gray-400 mt-1 text-center">Arahkan barcode ke kamera</p>
            </div>
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-600">Nama Barang</label>
            <input type="text" wire:model="nama"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            @error('nama') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-600">Kategori</label>
            <select wire:model="kategori_id"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                @endforeach
            </select>
            @error('kategori_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-600">Harga</label>
            <input type="number" wire:model="harga"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            @error('harga') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-600">Stok</label>
            <input type="number" wire:model="stok"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            @error('stok') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-600">Foto Barang</label>
            <input type="file" wire:model="foto" accept="image/*"
                class="w-full text-sm border rounded px-3 py-2 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700">
            @error('foto') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

            <div wire:loading wire:target="foto" class="text-xs text-gray-500 mt-1">Mengunggah...</div>

            @if ($foto)
            <img src="{{ $foto->temporaryUrl() }}" class="mt-2 w-20 h-20 object-cover rounded border">
            @elseif ($fotoLama)
            <img src="{{ asset('storage/' . $fotoLama) }}" class="mt-2 w-20 h-20 object-cover rounded border">
            @endif
        </div>

        <div class="sm:col-span-2 flex items-center gap-2 pt-2 border-t">
            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                {{ $editingId ? 'Simpan Perubahan' : 'Tambah Barang' }}
            </button>
            @if ($editingId)
            <button type="button" wire:click="batal"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Batal
            </button>
            <span class="text-sm text-gray-400">Sedang mengedit barang</span>
            @endif
        </div>
    </form>

    {{-- HEADER daftar + pencarian --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
        <h2 class="font-bold text-gray-700">Daftar Barang ({{ $barangs->count() }})</h2>
        <div class="relative w-full sm:w-72">
            <input type="text" wire:model.live.debounce.300ms="cari"
                placeholder="Cari nama atau kode barang..."
                class="w-full border rounded-lg pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0z" />
            </svg>
        </div>
    </div>

    {{-- TABEL untuk layar sedang ke atas --}}
    <div class="hidden md:block bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="p-3">Foto</th>
                    <th class="p-3">Kode</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3 text-right">Harga</th>
                    <th class="p-3 text-right">Stok</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($barangs as $barang)
                <tr class="hover:bg-gray-50">
                    <td class="p-3">
                        @if ($barang->foto)
                        <img src="{{ asset('storage/' . $barang->foto) }}" class="w-10 h-10 object-cover rounded">
                        @else
                        <div class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center text-gray-300 text-xs">N/A</div>
                        @endif
                    </td>
                    <td class="p-3 font-mono text-xs">{{ $barang->kode }}</td>
                    <td class="p-3 font-medium">{{ $barang->nama }}</td>
                    <td class="p-3">{{ $barang->kategori->nama ?? '-' }}</td>
                    <td class="p-3 text-right">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                    <td class="p-3 text-right">
                        <span class="{{ $barang->stok <= 5 ? 'text-red-600 font-medium' : '' }}">{{ $barang->stok }}</span>
                    </td>
                    <td class="p-3 text-center whitespace-nowrap">
                        <button wire:click="edit({{ $barang->id }})" class="text-blue-600 hover:underline">Edit</button>
                        <button wire:click="hapus({{ $barang->id }})" wire:confirm="Yakin hapus barang ini?" class="text-red-600 hover:underline ml-2">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-6 text-center text-gray-400">
                        {{ $cari ? 'Tidak ada barang yang cocok dengan pencarian.' : 'Belum ada barang.' }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- KARTU untuk layar kecil (HP) --}}
    <div class="md:hidden space-y-3">
        @forelse ($barangs as $barang)
        <div class="bg-white rounded-xl shadow p-4 flex gap-3">
            @if ($barang->foto)
            <img src="{{ asset('storage/' . $barang->foto) }}" class="w-16 h-16 object-cover rounded shrink-0">
            @else
            <div class="w-16 h-16 rounded bg-gray-100 flex items-center justify-center text-gray-300 text-xs shrink-0">N/A</div>
            @endif
            <div class="flex-1 min-w-0">
                <div class="font-medium">{{ $barang->nama }}</div>
                <div class="text-xs text-gray-400 font-mono">{{ $barang->kode }}</div>
                <div class="text-sm text-gray-600 mt-1">
                    {{ $barang->kategori->nama ?? '-' }} · Rp {{ number_format($barang->harga, 0, ',', '.') }}
                </div>
                <div class="text-sm mt-1">Stok:
                    <span class="{{ $barang->stok <= 5 ? 'text-red-600 font-medium' : 'font-medium' }}">{{ $barang->stok }}</span>
                </div>
                <div class="mt-2 flex gap-3 text-sm">
                    <button wire:click="edit({{ $barang->id }})" class="text-blue-600 hover:underline">Edit</button>
                    <button wire:click="hapus({{ $barang->id }})" wire:confirm="Yakin hapus barang ini?" class="text-red-600 hover:underline">Hapus</button>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow p-6 text-center text-gray-400">
            {{ $cari ? 'Tidak ada barang yang cocok.' : 'Belum ada barang.' }}
        </div>
        @endforelse
        {{-- Tombol halaman (pagination) --}}
        <div class="mt-4">
            {{ $barangs->links() }}
        </div>
    </div>
</div>

@script
<script>
    // Muat library ZXing dari CDN
    if (!window.ZXing) {
        const s = document.createElement('script');
        s.src = 'https://unpkg.com/@zxing/library@0.21.3/umd/index.min.js';
        document.head.appendChild(s);
    }

    window.scannerKode = function() {
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
                    const hints = new Map();
                    hints.set(ZXing.DecodeHintType.TRY_HARDER, true);
                    this.reader = new ZXing.BrowserMultiFormatReader(hints);
                    this.reader.decodeFromConstraints({
                            video: {
                                facingMode: 'environment',
                                width: {
                                    ideal: 1280
                                },
                                height: {
                                    ideal: 720
                                }
                            }
                        },
                        'reader-kode',
                        (result, err) => {
                            if (result) {
                                this.$wire.isiKodeHasilScan(result.getText());
                                this.stop();
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