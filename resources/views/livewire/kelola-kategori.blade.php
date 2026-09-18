<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Manajemen Kategori</h1>

    <form wire:submit="simpan" class="mb-6 flex gap-2">
        <div class="flex-1">
            <input type="text" wire:model="nama"
                placeholder="{{ $editingId ? 'Ubah nama kategori' : 'Nama kategori baru' }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            @error('nama') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
            {{ $editingId ? 'Simpan' : 'Tambah' }}
        </button>
        @if ($editingId)
        <button type="button" wire:click="batal"
            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
            Batal
        </button>
        @endif
    </form>

    <div class="bg-white rounded-lg shadow divide-y">
        @forelse ($kategoris as $kategori)
        <div class="p-4 flex items-center justify-between">
            <span class="text-gray-700">{{ $kategori->nama }}</span>
            <div class="flex gap-2">
                <button wire:click="edit({{ $kategori->id }})"
                    class="text-blue-600 text-sm hover:underline">Edit</button>
                <button wire:click="hapus({{ $kategori->id }})"
                    wire:confirm="Yakin hapus kategori ini?"
                    class="text-red-600 text-sm hover:underline">Hapus</button>
            </div>
        </div>
        @empty
        <div class="p-6 text-center text-gray-400">
            Belum ada kategori. Tambahkan lewat form di atas.
        </div>
        @endforelse
    </div>

    <button type="submit" wire:target="simpan" wire:loading.attr="disabled"
        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 disabled:opacity-60">
        <span wire:loading.remove wire:target="simpan">{{ $editingId ? 'Simpan' : 'Tambah' }}</span>
        <span wire:loading wire:target="simpan">Menyimpan...</span>
    </button>
</div>