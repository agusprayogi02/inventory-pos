<?php

namespace App\Exports;

use App\Models\StokKitchen;
use App\Enums\StokStatus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StokKitchenExport implements FromCollection, WithHeadings
{
  protected $date;

  public function __construct($date = null)
  {
    $this->date = $date;
  }

  public function collection()
  {
    $query = StokKitchen::with(['user', 'bahan']);
    if ($this->date) {
      $query->whereDate('tanggal', $this->date);
    }
    $data = $query->orderByDesc('tanggal')->get();
    return $data->map(function ($row) {
      return [
        $row->bahan->nama ?? '-',
        $row->tanggal ? date('d M Y', is_numeric($row->tanggal) ? $row->tanggal : strtotime($row->tanggal)) : '-',
        $row->user->name ?? '-',
        $row->jumlah_real,
        $row->status == StokStatus::PLUS->value ? 'Masuk' : 'Keluar',
        $row->keterangan ?? '-',
      ];
    });
  }

  public function headings(): array
  {
    return [
      'Nama Bahan',
      'Tanggal',
      'User',
      'Jumlah (gram)',
      'Status',
      'Keterangan',
    ];
  }
}
