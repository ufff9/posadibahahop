<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $kategori_id
 * @property string $kode
 * @property string $nama
 * @property string|null $foto
 * @property int $harga
 * @property int $stok
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Kategori $kategori
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = ['kategori_id', 'foto', 'kode', 'nama', 'harga', 'stok'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
