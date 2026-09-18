<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Barang> $barang
 * @property-read int|null $barang_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = ['nama'];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
