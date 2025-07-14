<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StokProduk extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'stok_produk';

    protected $fillable = [
        'produksi_id',
        'jumlah',
        'keterangan',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function produksi(): BelongsTo
    {
        return $this->belongsTo(Produksi::class);
    }
}
