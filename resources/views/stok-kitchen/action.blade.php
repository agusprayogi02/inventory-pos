<div class="btn-group" role="group">
    <a href="#" class="btn btn-sm btn-warning"
        onclick="addStokGudang({{ $row->id }}, '{{ $row->nama }}', {{ $row->jumlah_min }}, '{{ $row->satuan->nama }}', '{{ \App\Enums\StokStatus::PLUS->value }}')">
        <i class="fas fa-plus"></i> Tambah Stok
    </a>
    <a href="{{ route('stok-gudang.show', $row->id) }}" class="btn btn-sm btn-info">
        <i class="fas fa-eye"></i> Detail Stok
    </a>
    <button type="button" class="btn btn-sm btn-danger"
        onclick="addStokGudang({{ $row->id }}, '{{ $row->nama }}', {{ $row->jumlah_min }}, '{{ $row->satuan->nama }}', '{{ \App\Enums\StokStatus::MINUS->value }}')">
        <i class="fas fa-minus"></i> Kurangi Stok
    </button>
</div>
