<div class="btn-group" role="group">
    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i> Edit
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser({{ $user->id }})">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
