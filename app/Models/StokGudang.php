<?php

namespace App\Models;

use App\Enums\StokStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokGudang extends Model
{
    use SoftDeletes;

    protected $table = 'stok_gudang';

    protected $fillable = [
        'bahan_id',
        'user_id',
        'stok_gudang_ref',
        'jumlah',
        'tanggal',
        'status',
        'keterangan',
        'exp_date',
    ];

    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stokKitchen(): HasMany
    {
        return $this->hasMany(StokKitchen::class);
    }

    public function sisaStokKitchen()
    {
        return $this->status == StokStatus::MINUS->value ? '-' : $this->jumlah - ($this->stokKitchen()->sum('jumlah')
            + $this->where('stok_gudang_ref', $this->id)->where('status', StokStatus::MINUS->value)
                ->sum('jumlah'));
    }

    protected function casts(): array
    {
        return [
            'tanggal' => 'timestamp',
            'exp_date' => 'date',
        ];
    }
}
