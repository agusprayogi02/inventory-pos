<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokKitchen extends Model
{
    use SoftDeletes;

    protected $table = 'stok_kitchen';

    protected $fillable = [
        'bahan_id',
        'stok_gudang_id',
        'jumlah',
        'tanggal',
        'status',
    ];

    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class);
    }

    public function stokGudang(): BelongsTo
    {
        return $this->belongsTo(StokGudang::class);
    }

    protected function casts(): array
    {
        return [
            'tanggal' => 'timestamp',
        ];
    }
}
