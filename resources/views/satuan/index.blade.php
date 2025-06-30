@extends('adminlte::page')

@section('title', 'Satuan')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.Select2', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.satuan') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('adminlte::menu.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.satuan') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte-modal id="add-satuan" title="Tambah Satuan" size="md" theme="success" icon="fas fa-plus" v-centered
        static-backdrop scrollable>
        <form action="{{ route('satuan.store') }}" method="post" id="form-satuan">
            @csrf
            <x-adminlte.form.input name="nama" label="Nama Satuan" type="text" placeholder="Nama Satuan" required />
            <x-adminlte.form.input name="satuan" label="Satuan" type="text" placeholder="Satuan" required />
            <x-adminlte.form.input name="keterangan" label="Keterangan" type="text" placeholder="Keterangan" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" theme="success" label="Submit" form="form-satuan" />
                <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>

    <x-adminlte-modal id="edit-satuan" title="Edit Satuan" size="md" theme="info" icon="fas fa-edit" v-centered
        static-backdrop scrollable>
        <form action="" method="post" id="edit-form">
            @csrf
            @method('PUT')
            <x-adminlte.form.input name="nama" id="edit-nama" label="Nama Satuan" type="text"
                placeholder="Nama Satuan" required />
            <x-adminlte.form.input name="satuan" id="edit-satuan" label="Satuan" type="text" placeholder="Satuan"
                required />
            <x-adminlte.form.input name="keterangan" id="edit-keterangan" label="Keterangan" type="text"
                placeholder="Keterangan" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" theme="info" label="Update" form="edit-form" />
                <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="#" class="btn btn-primary" data-toggle="modal"
                        data-target="#add-satuan">{{ __('adminlte::menu.tambah') }}</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <x-adminlte.tool.datatable id="satuan-tables" :heads="['ID', 'Nama Satuan', 'Satuan', 'Keterangan', 'Aksi']" :config="[
                        'columns' => [
                            ['data' => 'id'],
                            ['data' => 'nama'],
                            ['data' => 'satuan'],
                            ['data' => 'keterangan'],
                            ['data' => 'action', 'orderable' => false, 'searchable' => false],
                        ],
                        'processing' => true,
                        'serverSide' => true,
                        'ajax' => [
                            'url' => route('satuan.data'),
                            'type' => 'GET',
                        ],
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
        function editSatuan(id, nama, satuan, keterangan) {
            // Set values to edit modal
            $('#edit-satuan #edit-nama').val(nama);
            $('#edit-satuan #edit-satuan').val(satuan);
            $('#edit-satuan #edit-keterangan').val(keterangan);
            $('#edit-satuan #edit-form').attr('action', '{{ route('satuan.update', ':id') }}'.replace(':id', id));

            // Show edit modal
            $('#edit-satuan').modal('show');
        }

        function deleteSatuan(id) {
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
                    form.action = '{{ route('satuan.destroy', ':id') }}'.replace(':id', id);

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
