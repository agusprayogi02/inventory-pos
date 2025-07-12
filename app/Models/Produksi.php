<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produksi extends Model
{
    use SoftDeletes;

    protected $table = 'produksi';

    protected $fillable = [
        'produk_id',
        'jumlah',
        'tanggal',
        'keterangan',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    public function stokProduk(): HasMany
    {
        return $this->hasMany(StokProduk::class);
    }

    public function getJumlahProduksiAttribute()
    {
        return $this->stokProduk()->sum('jumlah');
    }

    protected function casts(): array
    {
        return [
            'tanggal' => 'timestamp',
        ];
    }
}
