<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('components.layouts.app')]
class KelolaUser extends Component
{
    public ?int $editingId = null;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $role = 'kasir';

    public function simpan()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->editingId)],
            'password' => $this->editingId ? 'nullable|min:6' : 'required|min:6',
            'role' => 'required|in:admin,kasir',
        ], [
            'password.required' => 'Password wajib diisi untuk user baru.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        // Isi password hanya kalau diisi
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editingId) {
            User::find($this->editingId)->update($data);
            $pesan = 'User berhasil diperbarui.';
        } else {
            User::create($data);
            $pesan = 'User berhasil ditambahkan.';
        }

        $this->reset(['editingId', 'name', 'email', 'password', 'role']);
        $this->role = 'kasir';

        $this->dispatch('toast', message: $pesan, type: 'success');
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        $this->editingId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = ''; // password dikosongkan, diisi hanya kalau mau diganti
    }

    public function batal()
    {
        $this->reset(['editingId', 'name', 'email', 'password', 'role']);
        $this->role = 'kasir';
    }

    public function hapus(int $id)
    {
        // Jangan biarkan admin menghapus dirinya sendiri
        if ($id === auth()->id()) {
            $this->dispatch('toast', message: 'Tidak bisa menghapus akun sendiri.', type: 'error');

            return;
        }

        User::findOrFail($id)->delete();

        $this->dispatch('toast', message: 'User berhasil dihapus.', type: 'success');
    }

    public function render()
    {
        $users = User::latest()->get();

        return view('livewire.kelola-user', compact('users'));
    }
}
