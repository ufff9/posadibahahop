<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $barang_id
 * @property int $user_id
 * @property int $jumlah
 * @property string|null $keterangan
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Barang $barang
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereUserId($value)
 * @mixin \Eloquent
 */
class StokMasuk extends Model
{
    protected $table = 'stok_masuk';

    protected $fillable = ['barang_id', 'user_id', 'jumlah', 'keterangan'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
