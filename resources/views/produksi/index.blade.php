@extends('adminlte::page')

@section('title', 'Hasil Produksi')
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
            <h1>{{ __('adminlte::menu.hasil_produksi') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('adminlte::menu.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.hasil_produksi') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte-modal id="add-produksi" title="Tambah Hasil Produksi" size="md" theme="success" icon="fas fa-plus"
        v-centered static-backdrop scrollable>
        <form action="{{ route('produksi.store') }}" method="post" id="form-produksi">
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
            <x-adminlte.form.input name="jumlah" label="Jumlah" type="number" placeholder="Jumlah" required>
                <x-slot name="appendSlot">
                    <span class="input-group-text">
                        Pcs
                    </span>
                </x-slot>
            </x-adminlte.form.input>
            <x-adminlte.form.input name="tanggal" label="Tanggal" type="date" placeholder="Tanggal" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" theme="success" label="Submit" form="form-produksi" />
                <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>

    <x-adminlte-modal id="edit-produksi" title="Edit Hasil Produksi" size="md" theme="warning" icon="fas fa-edit"
        v-centered static-backdrop scrollable>
        <form action="{{ route('produksi.update', ':id') }}" method="post" id="edit-form">
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
            <x-adminlte.form.input name="jumlah" id="edit-jumlah" label="Jumlah" type="number" placeholder="Jumlah"
                required>
                <x-slot name="appendSlot">
                    <span class="input-group-text">
                        Pcs
                    </span>
                </x-slot>
            </x-adminlte.form.input>
            <x-adminlte.form.input name="tanggal" id="edit-tanggal" label="Tanggal" type="date" placeholder="Tanggal" />
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
                        data-target="#add-produksi">{{ __('adminlte::menu.tambah') }}</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <x-adminlte.tool.datatable id="produksi-tables" :heads="['Tanggal', 'Resep', 'Jumlah', 'Sisa Produksi', 'Aksi']" :config="[
                        'ajax' => route('produksi.data'),
                        'columns' => [
                            ['data' => 'tanggal'],
                            ['data' => 'resep_nama'],
                            ['data' => 'jumlah'],
                            ['data' => 'sisa_produksi'],
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
        function editProduksi(id, jumlah, tanggal, resep_id, resep_nama) {
            // Set values to edit modal
            $('#edit-produksi #edit-jumlah').val(jumlah);
            $('#edit-produksi #edit-tanggal').val(tanggal);
            $('#edit-produksi #edit-resep_id').val(resep_id).trigger('change');

            // Set value for resep select2
            let $resepSelect = $('#edit-produksi #edit-resep_id');
            if ($resepSelect.find("option[value='" + resep_id + "']").length) {
                $resepSelect.val(resep_id).trigger('change');
            } else {
                // If option not exist, create it and select
                let newOption = new Option(resep_nama, resep_id, true, true);
                $resepSelect.append(newOption).trigger('change');
            }

            $('#edit-produksi #edit-form').attr('action', '{{ route('produksi.update', ':id') }}'.replace(':id', id));


            // Show edit modal
            $('#edit-produksi').modal('show');
        }

        function deleteProduksi(id) {
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
                    form.action = '{{ route('produksi.destroy', ':id') }}'.replace(':id', id);

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
