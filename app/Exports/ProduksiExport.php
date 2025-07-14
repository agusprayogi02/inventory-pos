<?php

namespace App\Exports;

use App\Models\Produksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProduksiExport implements FromCollection, WithHeadings
{
    protected $dates;

    public function __construct($dates = null)
    {
        $this->dates = $dates;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Produksi::with('produk');
        if ($this->dates && count($this->dates) === 2) {
            $query->whereDate('tanggal', '>=', $this->dates[0])
                ->whereDate('tanggal', '<=', $this->dates[1]);
        }
        $produksi = $query->get();

        return $produksi->map(function ($item) {
            $jumlah_produksi = $item->jumlah_produksi;
            return [
                $item->tanggal ? date('d M Y', is_numeric($item->tanggal) ? $item->tanggal : strtotime($item->tanggal)) : '-',
                $item->produk ? $item->produk->nama : '-',
                $item->jumlah,
                $jumlah_produksi,
                $jumlah_produksi - $item->jumlah,
                $item->keterangan,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Produk',
            'Target',
            'Tercapai',
            'Sisa Produksi',
            'Keterangan',
        ];
    }
}
