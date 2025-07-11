<div class="btn-group" role="group">
    @if ($row->status == \App\Enums\StokStatus::PLUS->value)
        <button type="button" class="btn btn-sm btn-danger"
            onclick="minusStokGudang({{ $row->id }}, {{ $row->sisaStokGudang() }})">
            <i class="fas fa-minus"></i> Kurangi Stok
        </button>
    @else
        <button type="button" class="btn btn-sm btn-warning"
            onclick="changeStokGudang({{ $row->stok_gudang_ref }}, '{{ $row->sisaStokGudang() }}', {{ $row->id }}, {{ $row->jumlah }}, {{ json_encode(date('Y-m-d', $row->tanggal)) }}, {{ json_encode($row->keterangan) }})">
            <i class="fas fa-edit"></i> Edit Stok
        </button>
    @endif
</div>
