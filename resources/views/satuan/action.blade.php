<div class="btn-group" role="group">
    <a href="#" class="btn btn-sm btn-info"
        onclick="editSatuan({{ $row->id }}, '{{ $row->nama }}', '{{ $row->satuan }}', '{{ $row->keterangan }}')">
        <i class="fas fa-edit"></i> Edit
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteSatuan({{ $row->id }})">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
