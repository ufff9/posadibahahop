<?php

namespace App\Livewire;

use App\Models\Kategori;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class KelolaKategori extends Component
{
    public string $nama = '';

    public ?int $editingId = null;

    public function simpan()
    {
        $this->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama,' . $this->editingId,
        ]);

        Kategori::updateOrCreate(
            ['id' => $this->editingId],
            ['nama' => $this->nama]
        );

        $pesan = $this->editingId ? 'Kategori berhasil diperbarui.' : 'Kategori berhasil ditambahkan.';

        $this->reset(['nama', 'editingId']);

        Cache::forget('kategori_list');

        $this->dispatch('toast', message: $pesan, type: 'success');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        $this->editingId = $kategori->id;
        $this->nama = $kategori->nama;
    }

    public function batal()
    {
        $this->reset(['nama', 'editingId']);
    }

    public function hapus($id)
    {
        Kategori::findOrFail($id)->delete();

        Cache::forget('kategori_list');

        $this->dispatch('toast', message: 'Kategori berhasil dihapus.', type: 'success');
    }

    public function render()
    {
        $kategoris = Kategori::latest()->get();

        return view('livewire.kelola-kategori', compact('kategoris'));
    }
}
