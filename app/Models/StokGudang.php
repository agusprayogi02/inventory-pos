<?php

namespace App\Models;

use App\Enums\StokStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StokGudang extends Model
{
    use SoftDeletes, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function sisaStokGudang()
    {
        $jumSendiri = $this->where('stok_gudang_ref', $this->id)->where('status', StokStatus::MINUS->value)
            ->sum('jumlah');
        return $this->status == StokStatus::MINUS->value ? '-' : $this->jumlah - $jumSendiri;
    }

    protected function casts(): array
    {
        return [
            'tanggal' => 'timestamp',
            'exp_date' => 'date',
        ];
    }
}
