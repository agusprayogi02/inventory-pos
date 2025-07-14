<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Produk extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'produk';

    protected $fillable = [
        'resep_id',
        'satuan_id',
        'satuan_produk_id',
        'nama',
        'isi',
        'jumlah',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

    public function resep(): BelongsTo
    {
        return $this->belongsTo(Resep::class);
    }

    public function satuan(): BelongsTo
    {
        return $this->belongsTo(Satuan::class);
    }

    public function satuanProduk(): BelongsTo
    {
        return $this->belongsTo(Satuan::class, 'satuan_produk_id');
    }
}
