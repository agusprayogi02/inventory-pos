<div class="btn-group" role="group">
    <a href="#" class="btn btn-sm btn-warning"
        onclick="editBahan({{ $row->id }}, {{ $row->bahan_id }}, '{{ $row->bahan->nama }}', {{ $row->jumlah }}, {{ $row->resep_id }})">
        <i class="fas fa-edit"></i> Edit
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteBahan({{ $row->id }}, {{ $row->resep_id }})">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
