<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $transaksi_id
 * @property int $barang_id
 * @property int $jumlah
 * @property int $harga
 * @property int $subtotal
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Barang $barang
 * @property-read \App\Models\Transaksi $transaksi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereTransaksiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TransaksiDetail extends Model
{
    protected $table = 'transaksi_detail';

    protected $fillable = ['transaksi_id', 'barang_id', 'jumlah', 'harga', 'subtotal'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
