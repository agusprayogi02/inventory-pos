<div class="btn-group" role="group">
    <a href="#" class="btn btn-sm btn-warning"
        onclick="editProduk({{ $row->id }}, '{{ $row->nama }}', '{{ $row->jumlah }}', '{{ $row->isi }}', '{{ $row->satuan_id }}', '{{ addslashes($row->satuan ? $row->satuan->nama : '-') }}', '{{ $row->resep_id }}', '{{ addslashes($row->resep ? $row->resep->nama : '-') }}', '{{ $row->satuan_produk_id }}', '{{ addslashes($row->satuanProduk ? $row->satuanProduk->nama : '-') }}')">
        <i class="fas fa-edit"></i> Edit
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteProduk({{ $row->id }})">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
