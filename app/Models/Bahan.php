<?php

namespace App\Models;

use App\Enums\StokStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bahan extends Model
{
    use SoftDeletes;

    protected $table = 'bahan';

    protected $fillable = [
        'nama',
        'jumlah_min',
        'satuan_id',
    ];

    public function satuan(): BelongsTo
    {
        return $this->belongsTo(Satuan::class);
    }

    /**
     * Get all of the stokGudang for the Bahan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stokGudang(): HasMany
    {
        return $this->hasMany(StokGudang::class);
    }

    public function jumlahStokGudang()
    {
        return $this->jumlahStokGudangMasuk() - $this->jumlahStokGudangKeluar();
    }

    public function jumlahStokGudangMasuk()
    {
        return $this->stokGudang()->where('status', StokStatus::PLUS->value)->sum('jumlah');
    }

    public function jumlahStokGudangKeluar()
    {
        return $this->stokGudang()->where('status', StokStatus::MINUS->value)->sum('jumlah');
    }
}
