<div class="btn-group" role="group">
    <button class="btn btn-info btn-sm" onclick="showDetailStokKitchen({{ $row->id }}, '{{ $row->nama }}')">
        <i class="fas fa-info-circle"></i> Detail
    </button>
    <button class="btn btn-success btn-sm"
        onclick="showInputManualStok({{ $row->id }}, '{{ $row->nama }}', {{ $row->jumlah_min }})">
        <i class="fas fa-plus"></i> Tambah Bahan
    </button>
    <button class="btn btn-warning btn-sm"
        onclick="showInputStokKitchen({{ $row->id }}, '{{ $row->nama }}', {{ $row->jumlah_min }})">
        <i class="fas fa-minus"></i> Input Sisa Stok
    </button>
</div>
