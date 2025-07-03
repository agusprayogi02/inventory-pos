@extends('adminlte::page')

@section('title', 'Stok Kitchen')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.Select2', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.stok_kitchen') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('adminlte::menu.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.stok_kitchen') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte.tool.modal id="add-stok-kitchen" title="Tambah Stok Kitchen" size="md" theme="success" icon="fas fa-plus"
        v-centered static-backdrop scrollable>
        <form action="{{ route('stok-kitchen.store') }}" method="post" id="form-stok-kitchen">
            @csrf
            <x-adminlte.form.select2 name="bahan" id="add-bahan_id" label="Bahan" :config="[
                'required' => true,
                'allowClear' => true,
                'theme' => 'bootstrap4',
                'placeholder' => 'Pilih Bahan',
                'ajax' => [
                    'url' => route('bahan.select2'),
                    'type' => 'GET',
                ],
                'disabled' => true,
            ]" />
            <input type="hidden" name="bahan_id" id="add-bahan_id_input">
            <input type="hidden" name="status" id="add-status_input">
            <x-adminlte.form.input name="jumlah_min" id="add-jumlah_min" label="Isi" type="text" placeholder="Isi"
                readonly />
            <x-adminlte.form.select name="status" id="add-status" label="Status" placeholder="Status" disabled>
                <option value="{{ \App\Enums\StokStatus::PLUS->value }}">Masuk</option>
                <option value="{{ \App\Enums\StokStatus::MINUS->value }}">Keluar</option>
            </x-adminlte.form.select>
            <x-adminlte.form.input name="jumlah" id="add-jumlah" label="Jumlah" type="number" placeholder="Jumlah"
                required />
            <x-adminlte.form.input name="tanggal" id="add-tanggal" label="Tanggal Stok" type="date"
                placeholder="Tanggal Stok" required />
            <x-adminlte.form.input name="exp_date" label="Exp Date" type="date" placeholder="Exp Date" required />
            <x-adminlte.form.textarea name="keterangan" id="add-keterangan" label="Keterangan" placeholder="Keterangan" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" theme="success" label="Submit" form="form-stok-kitchen" />
                <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte.tool.modal>

    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
                    <a href="#" class="btn btn-primary" data-toggle="modal"
                        data-target="#add-stok-gudang">{{ __('adminlte::menu.tambah') }}</a>
                </div> --}}
                <!-- /.card-header -->
                <div class="card-body">
                    <x-adminlte.tool.datatable id="stok-kitchen-tables" :heads="['ID', 'Nama Bahan', 'Isi', 'Jumlah', 'Aksi']" :config="[
                        'columns' => [
                            ['data' => 'id'],
                            ['data' => 'nama'],
                            ['data' => 'isi'],
                            ['data' => 'jumlah'],
                            ['data' => 'action', 'orderable' => false, 'searchable' => false],
                        ],
                        'processing' => true,
                        'serverSide' => true,
                        'ajax' => [
                            'url' => route('stok-kitchen.data'),
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
        function addStokGudang(id, nama, jumlah, satuan, status) {
            // Set values to edit modal
            $('#add-stok-gudang #add-bahan_id').val(id);
            // Set value for select2 (with AJAX)
            let $select = $('#add-stok-gudang #add-bahan_id');
            if ($select.find("option[value='" + id + "']").length) {
                $select.val(id).trigger('change');
            } else {
                // If option not exist, create it and select
                let newOption = new Option(nama, id, true, true);
                $select.append(newOption).trigger('change');
            }
            let isPlus = status === '{{ \App\Enums\StokStatus::PLUS->value }}';
            $('#add-stok-gudang #add-jumlah_min').val(jumlah + ' ' + satuan);
            $('#add-stok-gudang #add-status').val(status);
            $('#add-stok-gudang #add-bahan_id_input').val(id);
            $('#add-stok-gudang #add-status_input').val(status);
            $('#add-stok-gudang #add-tanggal').val(new Date().toISOString().split('T')[0]);
            $('#add-stok-gudang #form-stok-gudang').attr('action', '{{ route('stok-gudang.store') }}');
            $('#add-stok-gudang #modal-title').text(isPlus ? 'Tambah Stok Gudang' : 'Kurangi Stok Gudang');
            $('#add-stok-gudang #modal-icon').attr('class', isPlus ? 'fas fa-plus mr-2' : 'fas fa-minus mr-2');

            // Show add modal
            $('#add-stok-gudang').modal('show');
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
