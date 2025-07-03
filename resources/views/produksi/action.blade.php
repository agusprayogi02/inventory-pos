<div class="btn-group" role="group">
    <a href="#" class="btn btn-sm btn-warning"
        onclick="editProduksi({{ $row->id }}, '{{ $row->jumlah }}', '{{ date('Y-m-d', $row->tanggal) }}', '{{ $row->resep_id }}', '{{ addslashes($row->resep ? $row->resep->nama : '-') }}')">
        <i class="fas fa-edit"></i> Edit
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteProduksi({{ $row->id }})">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
