<div class="w-full max-w-sm bg-white p-8 rounded-lg shadow">
    <h1 class="text-xl font-bold mb-6 text-center">Masuk ke Adibah Shop</h1>

    <form wire:submit="login" class="space-y-4">
        <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" wire:model="email"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Password</label>
            <input type="password" wire:model="password"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Masuk
        </button>
    </form>
</div>