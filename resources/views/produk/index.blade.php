@extends('adminlte::page')

@section('title', 'Produk')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.Select2', true)

@section('css')
    <style>
        .mb-12rem {
            margin-bottom: 12rem !important;
        }
    </style>
@endsection

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.produk') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('adminlte::menu.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.produk') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte-modal id="add-produk" title="Tambah Produk" size="md" theme="success" icon="fas fa-plus" v-centered
        static-backdrop scrollable>
        <form action="{{ route('produk.store') }}" method="post" id="form-produk">
            @csrf
            <x-adminlte.form.select2 id="resep_id" name="resep_id" label="Resep" :config="[
                'placeholder' => 'Pilih Resep',
                'allowClear' => true,
                'theme' => 'bootstrap4',
                'ajax' => [
                    'url' => route('resep.select2'),
                    'type' => 'GET',
                ],
            ]" />
            <x-adminlte.form.input name="nama" label="Nama Produk" type="text" placeholder="Nama Produk" />
            <x-adminlte.form.input name="isi" label="Isi" type="number" placeholder="Isi" />
            <x-adminlte.form.input name="jumlah" label="Prediksi Jumlah" type="number" placeholder="Prediksi Jumlah" />
            <x-adminlte.form.select2 id="satuan_id" name="satuan_id" label="Satuan" :config="[
                'placeholder' => 'Pilih Satuan',
                'allowClear' => true,
                'theme' => 'bootstrap4',
                'ajax' => [
                    'url' => route('satuan.select2'),
                    'type' => 'GET',
                ],
            ]" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" theme="success" label="Submit" form="form-produk" />
                <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>

    <x-adminlte-modal id="edit-produk" title="Edit Produk" size="md" theme="warning" icon="fas fa-edit" v-centered
        static-backdrop scrollable>
        <form action="{{ route('produk.update', ':id') }}" method="post" id="edit-form">
            @csrf
            @method('PUT')
            <x-adminlte.form.select2 id="edit-resep_id" name="resep_id" label="Resep" :config="[
                'placeholder' => 'Pilih Resep',
                'allowClear' => true,
                'theme' => 'bootstrap4',
                'ajax' => [
                    'url' => route('resep.select2'),
                    'type' => 'GET',
                ],
            ]" />
            <x-adminlte.form.input name="nama" id="edit-nama" label="Nama Produk" type="text"
                placeholder="Nama Produk" />
            <x-adminlte.form.input name="isi" id="edit-isi" label="Isi" type="number" placeholder="Isi" />
            <x-adminlte.form.input name="jumlah" id="edit-jumlah" label="Prediksi Jumlah" type="number"
                placeholder="Prediksi Jumlah" />
            <x-adminlte.form.select2 id="edit-satuan_id" name="satuan_id" label="Satuan" :config="[
                'placeholder' => 'Pilih Satuan',
                'allowClear' => true,
                'theme' => 'bootstrap4',
                'ajax' => [
                    'url' => route('satuan.select2'),
                    'type' => 'GET',
                ],
            ]" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" theme="warning" label="Submit" form="edit-form" />
                <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="#" class="btn btn-primary" data-toggle="modal"
                        data-target="#add-produk">{{ __('adminlte::menu.tambah') }}</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <x-adminlte.tool.datatable id="produk-tables" :heads="['ID', 'Nama Produk', 'Resep', 'Prediksi Jumlah', 'Isi', 'Aksi']" :config="[
                        'ajax' => route('produk.data'),
                        'columns' => [
                            ['data' => 'id'],
                            ['data' => 'nama'],
                            ['data' => 'resep_nama'],
                            ['data' => 'jumlah'],
                            ['data' => 'isi'],
                            ['data' => 'action', 'orderable' => false, 'searchable' => false],
                        ],
                        'processing' => true,
                        'serverSide' => false,
                        'pageLength' => 10,
                        'responsive' => true,
                    ]">
                    </x-adminlte.tool.datatable>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        function editProduk(id, nama, jumlah, isi, satuan_id, satuan_nama, resep_id, resep_nama) {
            // Set values to edit modal
            $('#edit-produk #edit-nama').val(nama);
            $('#edit-produk #edit-jumlah').val(jumlah);
            $('#edit-produk #edit-isi').val(isi);

            // Set value for resep select2
            let $resepSelect = $('#edit-produk #edit-resep_id');
            if ($resepSelect.find("option[value='" + resep_id + "']").length) {
                $resepSelect.val(resep_id).trigger('change');
            } else {
                // If option not exist, create it and select
                let newOption = new Option(resep_nama, resep_id, true, true);
                $resepSelect.append(newOption).trigger('change');
            }

            // Set value for satuan select2
            let $satuanSelect = $('#edit-produk #edit-satuan_id');
            if ($satuanSelect.find("option[value='" + satuan_id + "']").length) {
                $satuanSelect.val(satuan_id).trigger('change');
            } else {
                // If option not exist, create it and select
                let newOption = new Option(satuan_nama, satuan_id, true, true);
                $satuanSelect.append(newOption).trigger('change');
            }

            $('#edit-produk #edit-form').attr('action', '{{ route('produk.update', ':id') }}'.replace(':id', id));

            // Show edit modal
            $('#edit-produk').modal('show');
        }

        function deleteProduk(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('produk.destroy', ':id') }}'.replace(':id', id);

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

@endsection
