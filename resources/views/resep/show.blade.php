@extends('adminlte::page')

@section('title', 'Resep Detail ' . $resep->nama)

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.Select2', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Resep Detail {{ $resep->nama }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('adminlte::menu.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('resep.index') }}">{{ __('adminlte::menu.resep') }}</a></li>
                <li class="breadcrumb-item active">Resep Detail {{ $resep->nama }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte-modal id="add-bahan" title="Tambah Bahan" size="md" theme="success" icon="fas fa-plus" v-centered
        static-backdrop scrollable>
        <form action="{{ route('resep.bahan.store', $resep->id) }}" method="post" id="form-bahan">
            @csrf
            <x-adminlte.form.select2 id="add-bahan_id" name="bahan_id" label="Bahan" :config="[
                'allowClear' => true,
                'theme' => 'bootstrap4',
                'placeholder' => 'Pilih Bahan',
                'ajax' => [
                    'url' => route('bahan.select2'),
                    'type' => 'GET',
                ],
            ]" />
            <x-adminlte.form.input name="jumlah" label="Jumlah" type="number" placeholder="Jumlah" required>
                <x-slot name="appendSlot">
                    <span class="input-group-text">
                        Gram
                    </span>
                </x-slot>
            </x-adminlte.form.input>
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" type="submit" theme="success" label="Submit" form="form-bahan" />
            <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

    <x-adminlte-modal id="edit-bahan" title="Edit Bahan" size="md" theme="warning" icon="fas fa-edit" v-centered
        static-backdrop scrollable>
        <form action="" method="post" id="edit-form">
            @csrf
            @method('PUT')
            <x-adminlte.form.select2 id="edit-bahan_id" name="bahan_id" label="Bahan" :config="[
                'allowClear' => true,
                'theme' => 'bootstrap4',
                'placeholder' => 'Pilih Bahan',
                'ajax' => [
                    'url' => route('bahan.select2'),
                    'type' => 'GET',
                ],
            ]" />
            <x-adminlte.form.input name="jumlah" id="edit-jumlah" label="Jumlah" type="number" placeholder="Jumlah"
                required>
                <x-slot name="appendSlot">
                    <span class="input-group-text">
                        Gram
                    </span>
                </x-slot>
            </x-adminlte.form.input>
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
                    <a href="{{ route('resep.index') }}" class="btn btn-success mr-4">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-bahan">
                        <i class="fas fa-plus"></i> Tambah Bahan
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <x-adminlte.tool.datatable id="resep-bahan-tables" :heads="['ID', 'Nama Bahan', 'Jumlah', 'Aksi']" :config="[
                        'columns' => [
                            ['data' => 'id'],
                            ['data' => 'bahan_name'],
                            ['data' => 'jumlah'],
                            ['data' => 'action', 'orderable' => false, 'searchable' => false],
                        ],
                        'processing' => true,
                        'serverSide' => true,
                        'ajax' => [
                            'url' => route('resep.bahan', $resep->id),
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
        function editBahan(id, bahan_id, bahan_nama, jumlah, resepId) {
            $('#edit-bahan #edit-form').attr('action',
                '{{ route('resep.bahan.update', ['resep_id' => ':resep_id', 'id' => ':id']) }}'.replace(
                    ':resep_id', resepId).replace(':id', id));

            let $select = $('#edit-bahan #edit-bahan_id');
            if ($select.find("option[value='" + bahan_id + "']").length) {
                $select.val(bahan_id).trigger('change');
            } else {
                // If option not exist, create it and select
                let newOption = new Option(bahan_nama, bahan_id, true, true);
                $select.append(newOption).trigger('change');
            }

            $('#edit-bahan #edit-jumlah').val(jumlah);

            $('#edit-bahan').modal('show');
        }

        function deleteBahan(id, resepId) {
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
                    form.action = '{{ route('resep.bahan.destroy', ['resep_id' => ':resep_id', 'id' => ':id']) }}'
                        .replace(':resep_id', resepId).replace(':id', id);
                    console.log(form.action);

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
