<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Manajemen User</h1>

    <form wire:submit="simpan" class="mb-6 bg-white p-4 rounded-lg shadow grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Nama</label>
            <input type="text" wire:model="name"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" wire:model="email"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1">
                Password
                @if ($editingId)
                <span class="text-xs text-gray-400">(kosongkan jika tidak diubah)</span>
                @endif
            </label>
            <input type="password" wire:model="password"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Peran</label>
            <select wire:model="role"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                <option value="kasir">Kasir</option>
                <option value="admin">Admin</option>
            </select>
            @error('role') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="sm:col-span-2 flex gap-2">
            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                {{ $editingId ? 'Simpan' : 'Tambah User' }}
            </button>
            @if ($editingId)
            <button type="button" wire:click="batal"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Batal
            </button>
            @endif
        </div>
    </form>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3 text-center">Peran</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($users as $user)
                <tr>
                    <td class="p-3">
                        {{ $user->name }}
                        @if ($user->id === auth()->id())
                        <span class="text-xs text-blue-500">(Anda)</span>
                        @endif
                    </td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3 text-center">
                        <span class="px-2 py-1 rounded text-xs
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="p-3 text-center whitespace-nowrap">
                        <button wire:click="edit({{ $user->id }})"
                            class="text-blue-600 hover:underline">Edit</button>
                        @if ($user->id !== auth()->id())
                        <button wire:click="hapus({{ $user->id }})"
                            wire:confirm="Yakin hapus user ini?"
                            class="text-red-600 hover:underline ml-2">Hapus</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-400">Belum ada user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>