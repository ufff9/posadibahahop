<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Stok Masuk (Restock)</h1>

    <form wire:submit="simpan" class="mb-6 bg-white p-4 rounded-lg shadow grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="sm:col-span-1">
            <label class="block text-sm mb-1">Barang</label>
            <select wire:model="barang_id"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                <option value="">-- Pilih Barang --</option>
                @foreach ($barangs as $barang)
                <option value="{{ $barang->id }}">{{ $barang->nama }} (stok: {{ $barang->stok }})</option>
                @endforeach
            </select>
            @error('barang_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Jumlah Masuk</label>
            <input type="number" wire:model="jumlah"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            @error('jumlah') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Keterangan (opsional)</label>
            <input type="text" wire:model="keterangan" placeholder="Misal: dari supplier A"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            @error('keterangan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="sm:col-span-3">
            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Tambah Stok
            </button>
        </div>
    </form>

    <h2 class="font-bold text-gray-700 mb-3">Riwayat Stok Masuk Terakhir</h2>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm min-w-[600px]">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Barang</th>
                    <th class="p-3 text-right">Jumlah</th>
                    <th class="p-3">Keterangan</th>
                    <th class="p-3">Oleh</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($riwayat as $r)
                <tr>
                    <td class="p-3">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-3">{{ $r->barang->nama ?? 'Barang dihapus' }}</td>
                    <td class="p-3 text-right text-green-600 font-medium">+{{ $r->jumlah }}</td>
                    <td class="p-3 text-gray-500">{{ $r->keterangan ?: '-' }}</td>
                    <td class="p-3">{{ $r->user->name }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-400">
                        Belum ada riwayat stok masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>