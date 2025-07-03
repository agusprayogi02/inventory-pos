<div class="btn-group" role="group">
    <a href="#" class="btn btn-sm btn-warning"
        onclick="editStok({{ $row->id }}, '{{ $row->produk_id }}', '{{ addslashes($row->produk ? $row->produk->nama : '-') }}', '{{ $row->jumlah }}', '{{ addslashes($row->keterangan) }}')">
        <i class="fas fa-edit"></i> Edit
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteStok({{ $row->id }})">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
