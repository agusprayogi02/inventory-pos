@extends('adminlte::page')

@section('title', 'Produksi Stok ' . $produksi->produk->nama)

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.Select2', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Produksi Stok {{ $produksi->produk->nama }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('adminlte::menu.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('produksi.index') }}">{{ __('adminlte::menu.produksi') }}</a>
                </li>
                <li class="breadcrumb-item active">Produksi Stok {{ $produksi->produk->nama }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte-modal id="add-stok" title="Tambah Stok Produk" size="md" theme="success" icon="fas fa-plus" v-centered
        static-backdrop scrollable>
        <form action="{{ route('produksi.stok.store', $produksi->id) }}" method="post" id="form-stok">
            @csrf
            <input type="hidden" name="produksi_id" value="{{ $produksi->id }}">
            <x-adminlte.form.input name="jumlah" label="Jumlah" type="number" placeholder="Jumlah" required>
                <x-slot name="appendSlot">
                    <span class="input-group-text">
                        Produk
                    </span>
                </x-slot>
            </x-adminlte.form.input>
            <x-adminlte.form.textarea name="keterangan" label="Keterangan" placeholder="Keterangan" />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" type="submit" theme="success" label="Submit" form="form-stok" />
            <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

    <x-adminlte-modal id="edit-stok" title="Edit Stok" size="md" theme="warning" icon="fas fa-edit" v-centered
        static-backdrop scrollable>
        <form action="" method="post" id="edit-form">
            @csrf
            @method('PUT')
            <input type="hidden" name="produksi_id" value="{{ $produksi->id }}">
            <input type="hidden" name="is_produksi" value="1">
            <x-adminlte.form.input name="jumlah" id="edit-jumlah" label="Jumlah" type="number" placeholder="Jumlah"
                required>
                <x-slot name="appendSlot">
                    <span class="input-group-text">
                        Produk
                    </span>
                </x-slot>
            </x-adminlte.form.input>
            <x-adminlte.form.textarea name="keterangan" id="edit-keterangan" label="Keterangan" placeholder="Keterangan" />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" type="submit" theme="warning" label="Update" form="edit-form" />
            <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('produksi.index') }}" class="btn btn-success mr-4">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-stok">
                        <i class="fas fa-plus"></i> Tambah Stok
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <x-adminlte.tool.datatable id="stok-produk-tables" :heads="['Tanggal', 'Nama Produk', 'Jumlah', 'Keterangan', 'Aksi']" :config="[
                        'columns' => [
                            ['data' => 'tanggal'],
                            ['data' => 'produk_nama'],
                            ['data' => 'jumlah'],
                            ['data' => 'keterangan'],
                            ['data' => 'action', 'orderable' => false, 'searchable' => false],
                        ],
                        'processing' => true,
                        'serverSide' => true,
                        'ajax' => [
                            'url' => route('produksi.stok.data', [$produksi->id]),
                            'type' => 'GET',
                        ],
                        'pageLength' => 10,
                        'responsive' => true,
                    ]" />
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        function editStok(id, jumlah, keterangan) {
            $('#edit-stok #edit-form').attr('action',
                '{{ route('stok-produk.update', [':id']) }}'.replace(':id', id));

            $('#edit-stok #edit-jumlah').val(jumlah);
            $('#edit-stok #edit-keterangan').val(keterangan);

            $('#edit-stok').modal('show');
        }

        function deleteStok(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action =
                        '{{ route('stok-produk.destroy', [':id']) }}'.replace(':id', id);
                    console.log(form.action);

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const isProduksi = document.createElement('input');
                    isProduksi.type = 'hidden';
                    isProduksi.name = 'produksi_id';
                    isProduksi.value = '{{ $produksi->id }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    form.appendChild(isProduksi);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
