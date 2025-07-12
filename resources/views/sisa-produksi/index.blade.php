@extends('adminlte::page')

@section('title', 'Sisa Produksi')
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
            <h1>{{ __('adminlte::menu.sisa_produksi') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('adminlte::menu.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.sisa_produksi') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte-modal id="add-produksi" title="Tambah Sisa Produksi" size="md" theme="success" icon="fas fa-plus"
        v-centered static-backdrop scrollable>
        <form action="{{ route('sisa-produksi.store') }}" method="post" id="form-produksi">
            @csrf
            <x-adminlte.form.select2 id="produk_id" name="produk_id" label="Produk" :config="[
                'placeholder' => 'Pilih Produk',
                'allowClear' => true,
                'theme' => 'bootstrap4',
                'ajax' => [
                    'url' => route('produk.select2'),
                    'type' => 'GET',
                ],
            ]" />
            <x-adminlte.form.input name="tanggal" label="Tanggal" type="date" placeholder="Tanggal"
                value="{{ now()->format('Y-m-d') }}" />
            <x-adminlte.form.input name="jumlah" label="Jumlah Target" type="number" placeholder="Jumlah" required />
            <x-adminlte-select name="status" id="add-status" label="Status">
                <option value="baik">Baik</option>
                <option value="rusak">Rusak</option>
                <option value="kedaluarsa">Kedaluarsa</option>
                <option value="kecil">Kecil</option>
                <option value="besar">Besar</option>
            </x-adminlte-select>
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" theme="success" label="Submit" form="form-produksi" />
                <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>

    <x-adminlte-modal id="edit-produksi" title="Edit Sisa Produksi" size="md" theme="warning" icon="fas fa-edit"
        v-centered static-backdrop scrollable>
        <form action="{{ route('sisa-produksi.update', ':id') }}" method="post" id="edit-form">
            @csrf
            @method('PUT')
            <x-adminlte.form.select2 id="edit-produk_id" name="produk_id" label="Produk" :config="[
                'placeholder' => 'Pilih Produk',
                'allowClear' => true,
                'theme' => 'bootstrap4',
                'ajax' => [
                    'url' => route('produk.select2'),
                    'type' => 'GET',
                ],
            ]" />
            <x-adminlte.form.input name="tanggal" id="edit-tanggal" label="Tanggal" type="date" placeholder="Tanggal" />
            <x-adminlte.form.input name="jumlah" id="edit-jumlah" label="Jumlah" type="number" placeholder="Jumlah"
                required />
            <x-adminlte-select name="status" id="add-status" label="Status">
                <option value="baik">Baik</option>
                <option value="rusak">Rusak</option>
                <option value="kedaluarsa">Kedaluarsa</option>
                <option value="kecil">Kecil</option>
                <option value="besar">Besar</option>
            </x-adminlte-select>
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
                    <x-adminlte.tool.datatable id="produksi-tables" :heads="['Tanggal', 'Produk', 'Status', 'Jumlah', 'Aksi']" :config="[
                        'ajax' => [
                            'url' => route('sisa-produksi.data'),
                            'type' => 'GET',
                        ],
                        'columns' => [
                            ['data' => 'tanggal'],
                            ['data' => 'produk_nama'],
                            ['data' => 'status'],
                            ['data' => 'jumlah'],
                            ['data' => 'action', 'orderable' => false, 'searchable' => false],
                        ],
                        'processing' => true,
                        'serverSide' => true,
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
        function editSisaProduksi(id, jumlah, tanggal, produk_id, produk_nama, status) {
            // Set values to edit modal
            $('#edit-produksi #edit-jumlah').val(jumlah);
            $('#edit-produksi #edit-tanggal').val(tanggal);
            $('#edit-produksi #edit-produk_id').val(produk_id).trigger('change');
            $('#edit-produksi #edit-status').val(status).trigger('change');

            // Set value for resep select2
            let $produkSelect = $('#edit-produksi #edit-produk_id');
            if ($produkSelect.find("option[value='" + produk_id + "']").length) {
                $produkSelect.val(produk_id).trigger('change');
            } else {
                // If option not exist, create it and select
                let newOption = new Option(produk_nama, produk_id, true, true);
                $produkSelect.append(newOption).trigger('change');
            }

            $('#edit-produksi #edit-form').attr('action', '{{ route('sisa-produksi.update', ':id') }}'.replace(':id', id));


            // Show edit modal
            $('#edit-produksi').modal('show');
        }

        function deleteSisaProduksi(id) {
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
                    form.action = '{{ route('sisa-produksi.destroy', ':id') }}'.replace(':id', id);

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
