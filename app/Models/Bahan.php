<?php

namespace App\Models;

use App\Enums\StokStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Bahan extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'bahan';

    protected $fillable = [
        'nama',
        'jumlah_min',
        'satuan_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'jumlah_min', 'satuan_id'])
            ->dontSubmitEmptyLogs();
    }

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

    public function stokKitchen(): HasMany
    {
        return $this->hasMany(StokKitchen::class);
    }

    public function jumlahStokGudang()
    {
        return $this->jumlahStokGudangMasuk() - ($this->jumlahStokGudangKeluar() + $this->jumlahStokKitMasuk());
    }

    public function jumlahStokKitMasuk()
    {
        return $this->stokKitchen()->where('status', StokStatus::PLUS->value)->sum('jumlah');
    }

    public function jumlahStokGudangMasuk()
    {
        return $this->stokGudang()->where('status', StokStatus::PLUS->value)->sum('jumlah');
    }


    public function jumlahStokGudangKeluar()
    {
        return $this->stokGudang()->where('status', StokStatus::MINUS->value)->sum('jumlah');
    }

    public function stokRealMasuk()
    {
        return $this->stokKitchen()->where('status', StokStatus::PLUS->value)->sum('jumlah_real');
    }

    public function stokRealKeluar()
    {
        return $this->stokKitchen()->where('status', StokStatus::MINUS->value)->sum('jumlah_real');
    }

    public function sisaStokReal()
    {
        return $this->stokRealMasuk() - $this->stokRealKeluar();
    }
}
