<div class="btn-group" role="group">
    <a href="#" class="btn btn-sm btn-warning"
        onclick="editBahan({{ $row->id }}, '{{ $row->nama }}', '{{ $row->jumlah_min }}', '{{ $row->satuan_id }}', '{{ addslashes($row->satuan ? $row->satuan->nama : '-') }}')">
        <i class="fas fa-edit"></i> Edit
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteBahan({{ $row->id }})">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
