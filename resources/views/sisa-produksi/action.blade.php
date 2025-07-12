<div class="btn-group" role="group">
    <a href="#" class="btn btn-sm btn-warning"
        onclick="editSisaProduksi({{ $row->id }}, '{{ $row->jumlah }}', '{{ date('Y-m-d', strtotime($row->tanggal)) }}', '{{ $row->produk_id }}', '{{ addslashes($row->produk ? $row->produk->nama : '-') }}', '{{ $row->status }}')">
        <i class="fas fa-edit"></i> Edit
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteSisaProduksi({{ $row->id }})">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
