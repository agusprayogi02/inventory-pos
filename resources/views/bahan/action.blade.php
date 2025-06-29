<div class="btn-group" role="group">
    <a href="{{ route('bahan.edit', $bahan->id) }}" class="btn btn-sm btn-info">
        <i class="fas fa-edit"></i> Edit
    </a>
    <form action="{{ route('bahan.destroy', $bahan->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger"
            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
            <i class="fas fa-trash"></i> Hapus
        </button>
    </form>
</div>
