<div class="btn-group" role="group">
    <a href="{{ route('resep.show', $row->id) }}" class="btn btn-sm btn-primary">
        <i class="fas fa-eye"></i> View
    </a>
    <a href="#" class="btn btn-sm btn-warning"
        onclick="editResep({{ $row->id }}, '{{ $row->nama }}', {{ $row->resep_id }})">
        <i class="fas fa-edit"></i> Edit
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteResep({{ $row->id }}, {{ $row->resep_id }})">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
