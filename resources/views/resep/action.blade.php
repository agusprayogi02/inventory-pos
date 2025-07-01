<div class="btn-group" role="group">
    <a href="#" class="btn btn-sm btn-warning" onclick="editResep({{ $row->id }}, '{{ $row->nama }}')">
        <i class="fas fa-edit"></i> Edit
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteResep({{ $row->id }})">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
