@extends('adminlte::page')

@section('title', 'Resep')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.Select2', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.resep') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('adminlte::menu.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.resep') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte-modal id="add-resep" title="Tambah Resep" size="md" theme="success" icon="fas fa-plus" v-centered
        static-backdrop scrollable>
        <form action="{{ route('resep.store') }}" method="post" id="form-resep">
            @csrf
            <x-adminlte.form.input name="nama" label="Nama Resep" type="text" placeholder="Nama Resep" required />
            <input type="hidden" name="user_id" id="add-user_id" value="{{ auth()->user()->id }}">

            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" theme="success" label="Submit" form="form-resep" />
                <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>

    <x-adminlte-modal id="edit-resep" title="Edit Resep" size="md" theme="warning" icon="fas fa-edit" v-centered
        static-backdrop scrollable>
        <form action="{{ route('resep.update', ':id') }}" method="post" id="edit-form">
            @csrf
            @method('PUT')
            <x-adminlte.form.input name="nama" id="edit-nama" label="Nama Resep" type="text" placeholder="Nama Resep"
                required />
            <input type="hidden" name="user_id" id="edit-user_id" value="{{ auth()->user()->id }}">
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" theme="warning" label="Update" form="edit-form" />
                <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="#" class="btn btn-primary" data-toggle="modal"
                        data-target="#add-resep">{{ __('adminlte::menu.tambah') }}</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <x-adminlte.tool.datatable id="resep-tables" :heads="['ID', 'Nama Resep', 'Dibuat Oleh', 'Aksi']" :config="[
                        'columns' => [
                            ['data' => 'id'],
                            ['data' => 'nama'],
                            ['data' => 'user_name'],
                            ['data' => 'action', 'orderable' => false, 'searchable' => false],
                        ],
                        'processing' => true,
                        'serverSide' => true,
                        'ajax' => [
                            'url' => route('resep.data'),
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
        function editResep(id, nama) {
            // Set values to edit modal
            $('#edit-resep #edit-nama').val(nama);
            $('#edit-resep #edit-form').attr('action', '{{ route('resep.update', ':id') }}'.replace(':id', id));

            // Show edit modal
            $('#edit-resep').modal('show');
        }

        function deleteResep(id) {
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
                    form.action = '{{ route('resep.destroy', ':id') }}'.replace(':id', id);

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
