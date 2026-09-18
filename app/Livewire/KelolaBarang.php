<?php

namespace App\Livewire;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class KelolaBarang extends Component
{
    use WithFileUploads, WithPagination;

    public ?int $editingId = null;

    public string $cari = '';

    public string $kode = '';

    public string $nama = '';

    public $kategori_id = '';

    public $harga = '';

    public $stok = '';

    public $foto;

    public $fotoLama = null;

    public function simpan()
    {
        $this->validate([
            'kode' => 'required|string|max:50|unique:barang,kode,' . $this->editingId,
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|max:2048',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $dataFoto = $this->fotoLama;
        if ($this->foto) {
            $dataFoto = $this->foto->store('barang', 'public');
        }

        Barang::updateOrCreate(
            ['id' => $this->editingId],
            [
                'kode' => $this->kode,
                'nama' => $this->nama,
                'foto' => $dataFoto,
                'kategori_id' => $this->kategori_id,
                'harga' => $this->harga,
                'stok' => $this->stok,
            ]
        );

        $pesan = $this->editingId ? 'Barang berhasil diperbarui.' : 'Barang berhasil ditambahkan.';

        $this->reset(['editingId', 'kode', 'nama', 'kategori_id', 'harga', 'stok', 'foto', 'fotoLama']);

        $this->dispatch('toast', message: $pesan, type: 'success');
    }

    public function edit(int $id)
    {
        $barang = Barang::findOrFail($id);
        $this->editingId = $barang->id;
        $this->kode = $barang->kode;
        $this->nama = $barang->nama;
        $this->kategori_id = $barang->kategori_id;
        $this->harga = $barang->harga;
        $this->stok = $barang->stok;
        $this->fotoLama = $barang->foto;
        $this->foto = null;
    }

    public function batal()
    {
        $this->reset(['editingId', 'kode', 'nama', 'kategori_id', 'harga', 'stok', 'foto', 'fotoLama']);
    }

    public function hapus(int $id)
    {
        Barang::findOrFail($id)->delete();

        $this->dispatch('toast', message: 'Barang berhasil dihapus.', type: 'success');
    }

    public function updatingCari()
    {
        $this->resetPage();
    }

    public function render()
    {
        $barangs = Barang::with('kategori')
            ->when($this->cari, function ($query) {
                $query->where('nama', 'like', '%' . $this->cari . '%')
                    ->orWhere('kode', 'like', '%' . $this->cari . '%');
            })
            ->latest()
            ->paginate(20);

        $kategoris = Kategori::orderBy('nama')->get();

        return view('livewire.kelola-barang', compact('barangs', 'kategoris'));
    }

    public function isiKodeHasilScan($kode)
    {
        $this->kode = $kode;

        // Cek apakah barcode ini sudah dipakai barang lain
        $barang = Barang::where('kode', $kode)->first();

        if ($barang && $barang->id !== $this->editingId) {
            $this->dispatch('toast', message: 'Barcode ini sudah dipakai: ' . $barang->nama, type: 'error');
        } else {
            $this->dispatch('toast', message: 'Kode terisi dari scan.', type: 'success');
        }
    }
}
