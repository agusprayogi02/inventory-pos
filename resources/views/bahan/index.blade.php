@extends('adminlte::page')

@section('title', 'Bahan')
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
            <h1>{{ __('adminlte::menu.bahan') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('adminlte::menu.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.bahan') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte-modal id="add-bahan" title="Tambah Bahan" size="md" theme="success" icon="fas fa-plus" v-centered
        static-backdrop scrollable>
        <form action="{{ route('bahan.store') }}" method="post" id="form-bahan">
            @csrf
            <x-adminlte.form.input name="nama" label="Nama Bahan" type="text" placeholder="Nama Bahan" />
            <x-adminlte.form.input name="jumlah_min" label="Jumlah Minimum" type="number" placeholder="Jumlah Minimum" />
            <x-adminlte.form.select2 id="satuan_id" name="satuan_id" label="Satuan" :config="[
                'placeholder' => 'Pilih Satuan',
                'allowClear' => true,
                'theme' => 'bootstrap4',
                'data' => [
                    'placeholder' => 'Pilih Satuan',
                ],
                'ajax' => [
                    'url' => route('satuan.select2'),
                    'type' => 'GET',
                ],
            ]" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" theme="success" label="Submit" form="form-bahan" />
                <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>

    <x-adminlte-modal id="edit-bahan" title="Edit Bahan" size="md" theme="warning" icon="fas fa-edit" v-centered
        static-backdrop scrollable>
        <form action="{{ route('bahan.update', ':id') }}" method="post" id="edit-form">
            @csrf
            @method('PUT')
            <x-adminlte.form.input name="nama" id="edit-nama" label="Nama Bahan" type="text"
                placeholder="Nama Bahan" />
            <x-adminlte.form.input name="jumlah_min" id="edit-jumlah_min" label="Jumlah Minimum" type="number"
                placeholder="Jumlah Minimum" />
            <x-adminlte.form.select2 id="edit-satuan_id" name="satuan_id" label="Satuan" :config="[
                'placeholder' => 'Pilih Satuan',
                'allowClear' => true,
                'theme' => 'bootstrap4',
                'data' => [
                    'placeholder' => 'Pilih Satuan',
                ],
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
                        data-target="#add-bahan">{{ __('adminlte::menu.tambah') }}</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <x-adminlte.tool.datatable id="bahan-tables" :heads="['ID', 'Nama Bahan', 'Jumlah Minimum', 'Satuan', 'Aksi']" :config="[
                        'ajax' => route('bahan.data'),
                        'columns' => [
                            ['data' => 'id'],
                            ['data' => 'nama'],
                            ['data' => 'jumlah_min'],
                            ['data' => 'satuan_nama'],
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
        function editBahan(id, nama, jumlah_min, satuan_id, satuan_nama) {
            // Set values to edit modal
            $('#edit-bahan #edit-nama').val(nama);
            $('#edit-bahan #edit-jumlah_min').val(jumlah_min);

            // Set value for select2 (with AJAX)
            let $select = $('#edit-bahan #edit-satuan_id');
            if ($select.find("option[value='" + satuan_id + "']").length) {
                $select.val(satuan_id).trigger('change');
            } else {
                // If option not exist, create it and select
                let newOption = new Option(satuan_nama, satuan_id, true, true);
                $select.append(newOption).trigger('change');
            }

            $('#edit-bahan #edit-form').attr('action', '{{ route('bahan.update', ':id') }}'.replace(':id', id));

            // Show edit modal
            $('#edit-bahan').modal('show');
        }

        function deleteBahan(id) {
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
                    form.action = '{{ route('bahan.destroy', ':id') }}'.replace(':id', id);

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
