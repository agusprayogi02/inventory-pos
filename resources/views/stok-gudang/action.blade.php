<div class="btn-group" role="group">
    <a href="#" class="btn btn-sm btn-warning"
        onclick="addStokGudang({{ $row->id }}, '{{ $row->nama }}', {{ $row->jumlah_min }}, '{{ $row->satuan->nama }}', '{{ \App\Enums\StokStatus::PLUS->value }}')">
        <i class="fas fa-plus"></i> Tambah Stok
    </a>
    <a href="{{ route('stok-gudang.show', $row->id) }}" class="btn btn-sm btn-info">
        <i class="fas fa-eye"></i> Detail Stok
    </a>
</div>
