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
    <x-adminlte.tool.modal id="modal-resep" title="Pilih Resep" size="lg" theme="info" icon="fas fa-utensils" v-centered
        static-backdrop scrollable>
        <div class="mb-3">
            <label for="select-resep">Pilih Resep</label>
            <select id="select-resep" class="form-control"></select>
        </div>
        {{-- Tambah field jumlah dari resep --}}
        <x-adminlte.form.input name="jumlah" id="jumlah_resep" label="Jumlah Resep" type="number"
            placeholder="Jumlah Resep" required>
            <x-slot name="appendSlot">
                <div class="input-group-text">
                    <span>Proses</span>
                </div>
            </x-slot>
        </x-adminlte.form.input>

        <div id="resep-bahan-section" style="display:none;">
            <h5>Bahan Resep</h5>
            <table class="table table-bordered" id="resep-bahan-table">
                <thead>
                    <tr>
                        <th>Nama Bahan</th>
                        <th>Isi (jumlah_min)</th>
                        <th>Dibutuhkan</th>
                        <th>Total Diambil</th>
                        <th>Stok Tersedia</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <button class="btn btn-success" id="proses-resep-btn">Proses ke Stok Kitchen</button>
        </div>
    </x-adminlte.tool.modal>

    <x-adminlte.tool.modal id="add-stok-kitchen" title="Tambah Stok Kitchen" size="md" theme="success"
        icon="fas fa-plus" v-centered static-backdrop scrollable>
        <form action="{{ route('stok-kitchen.store') }}" method="post" id="form-stok-kitchen">
            @csrf
            <input type="hidden" name="bahan_id" id="add-bahan_id">
            <input type="hidden" name="jumlah_min" id="add-jumlah_min">
            <input type="hidden" name="status" id="add-status_input">
            <x-adminlte.form.input name="tanggal" id="add-tanggal" label="Tanggal Stok" type="date"
                placeholder="Tanggal Stok" value="{{ date('Y-m-d') }}" required />
            <x-adminlte.form.select name="status_gimik" id="add-status" label="Status" placeholder="Status" required
                disabled>
                <option value="{{ \App\Enums\StokStatus::PLUS->value }}">Tambah Bahan</option>
                <option value="{{ \App\Enums\StokStatus::MINUS->value }}">Sisa Bahan</option>
            </x-adminlte.form.select>
            <div id="jumlah-field">
                <x-adminlte.form.input name="jumlah" id="add-jumlah" label="Jumlah" type="number" placeholder="Jumlah"
                    required />
            </div>
            <x-adminlte.form.input name="jumlah_real" id="add-jumlah_real" label="Jumlah Dalam Gram" type="text"
                placeholder="Jumlah Dalam Satuan" required>
                <x-slot name="appendSlot">
                    <div class="input-group-text">
                        <span>Gram</span>
                    </div>
                </x-slot>
            </x-adminlte.form.input>
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
                <div class="card-header row align-items-center">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <button class="btn btn-primary" id="open-resep-modal">Pilih Resep</button>
                    </div>
                    <div class="col-md-6">
                        <form id="export-stok-kitchen-form" class="form-inline float-md-right" method="GET"
                            action="{{ route('stok-kitchen.export') }}">
                            <input type="date" name="date" id="export-date" class="form-control mr-2"
                                style="min-width: 180px; margin-right: 8px;" required />
                            <x-adminlte-button type="submit" theme="outline-success" icon="fas fa-file-excel"
                                label="Export Excel" id="export-stok-kitchen-btn" />
                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <x-adminlte.tool.datatable id="stok-kitchen-tables" :heads="['Nama Bahan', 'Sisa Stok Bahan', 'Aksi']" :config="[
                        'columns' => [
                            ['data' => 'nama'],
                            ['data' => 'sisa'],
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
                    ]" />
                </div>
            </div>
        </div>
    </div>

    <x-adminlte.tool.modal id="modal-detail-stok-kitchen" title="Detail Stok Kitchen" size="lg" theme="info"
        icon="fas fa-info-circle" v-centered scrollable>
        <div id="detail-stok-kitchen-content"></div>
    </x-adminlte.tool.modal>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Buka modal resep
            $('#open-resep-modal').on('click', function() {
                $('#modal-resep').modal('show');
                // Reset
                $('#select-resep').val(null).trigger('change');
                $('#resep-bahan-section').hide();
            });

            // Select2 resep
            $('#select-resep').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih Resep',
                dropdownParent: $('#modal-resep'),
                ajax: {
                    url: '{{ route('resep.select2') }}',
                    dataType: 'json',
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    }
                }
            });

            let resepId = null;
            let bahanResep = [];

            // tolong ambil jumlah dari resep
            $('#jumlah_resep').on('change', function() {
                let jumlah = $(this).val();
                let resepId = $('#select-resep').val();
                if (!jumlah) return;
                $.get(`{{ url('transaksi/stok-kitchen/resep') }}/${resepId}/bahan?jumlah=${jumlah}`,
                    function(res) {
                        bahanResep = res.bahan;
                        let tbody = '';
                        bahanResep.forEach(function(row) {
                            tbody += `<tr>
                            <td>${row.nama}</td>
                            <td>${row.jumlah_min} ${row.satuan}</td>
                            <td>${row.dibutuhkan} ${row.satuan}</td>
                            <td>${row.total_diambil} ${row.satuan}</td>
                            <td>${row.stok_tersedia} ${row.satuan}</td>
                        </tr>`;
                        });
                        $('#resep-bahan-table tbody').html(tbody);
                        $('#resep-bahan-section').show();
                    });
            });

            $('#select-resep').on('change', function() {
                resepId = $(this).val();
                let jumlah = $('#jumlah_resep').val();
                if (!resepId || !jumlah) return;
                $.get(`{{ url('transaksi/stok-kitchen/resep') }}/${resepId}/bahan?jumlah=${jumlah}`,
                    function(res) {
                        bahanResep = res.bahan;
                        let tbody = '';
                        bahanResep.forEach(function(row) {
                            tbody += `<tr>
                            <td>${row.nama}</td>
                            <td>${row.jumlah_min} ${row.satuan}</td>
                            <td>${row.dibutuhkan} ${row.satuan}</td>
                            <td>${row.total_diambil} ${row.satuan}</td>
                            <td>${row.stok_tersedia} ${row.satuan}</td>
                        </tr>`;
                        });
                        $('#resep-bahan-table tbody').html(tbody);
                        $('#resep-bahan-section').show();
                    });
            });

            $('#proses-resep-btn').on('click', function() {
                if (!resepId) return;
                $.ajax({
                    url: `{{ url('transaksi/stok-kitchen/resep') }}/${resepId}/proses`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        jumlah: $('#jumlah_resep').val()
                    },
                    success: function(res) {
                        Swal.fire('Sukses', 'Berhasil menambah stok kitchen dari resep',
                            'success');
                        $('#resep-bahan-section').hide();
                        $('#select-resep').val(null).trigger('change');
                        $('#modal-resep').modal('hide');
                        // reload datatable jika perlu
                        $('#stok-kitchen-tables').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            Swal.fire('Gagal', errors.join('<br>'), 'error');
                        } else {
                            Swal.fire('Gagal', 'Terjadi kesalahan server', 'error');
                        }
                    }
                });
            });

            $('#export-stok-kitchen-form').on('submit', function(e) {
                if (!$('#export-date').val()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Tanggal',
                        text: 'Silakan pilih tanggal terlebih dahulu sebelum mengekspor data.',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
            });
        });

        function editStokKitchen(id, nama, jumlah_min, satuan) {
            // Set values to edit modal
            $('#add-stok-kitchen #add-bahan_id').val(id);
            // Set value for select2 (with AJAX)
            let $select = $('#add-stok-kitchen #add-bahan_id');
            if ($select.find("option[value='" + id + "']").length) {
                $select.val(id).trigger('change');
            } else {
                // If option not exist, create it and select
                let newOption = new Option(nama, id, true, true);
                $select.append(newOption).trigger('change');
            }
            $('#add-stok-kitchen #add-jumlah_min').val(jumlah_min + ' ' + satuan);
            $('#add-stok-kitchen #add-tanggal').val(new Date().toISOString().split('T')[0]);
            $('#add-stok-kitchen #form-stok-kitchen').attr('action', '{{ route('stok-kitchen.update', ':id') }}'.replace(
                ':id', id));

            // Add method field for PUT
            if (!$('#add-stok-kitchen #method-field').length) {
                $('#add-stok-kitchen #form-stok-kitchen').append(
                    '<input type="hidden" name="_method" value="PUT" id="method-field">');
            }

            // Show edit modal
            $('#add-stok-kitchen').modal('show');
        }

        function deleteStokKitchen(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data stok kitchen yang dihapus tidak dapat dikembalikan!",
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
                    form.action = '{{ route('stok-kitchen.destroy', ':id') }}'.replace(':id', id);

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

        function showDetailStokKitchen(bahanId, nama) {
            $('#modal-detail-stok-kitchen .modal-title').text('Detail Stok Kitchen: ' + nama);
            $('#detail-stok-kitchen-content').html('<div class="text-center">Loading...</div>');
            $.get(`{{ url('transaksi/stok-kitchen/detail') }}/${bahanId}`, function(res) {
                $('#detail-stok-kitchen-content').html(res);
            });
            $('#modal-detail-stok-kitchen').modal('show');
        }

        function showInputManualStok(bahanId, nama, jumlah_min, stok_gudang_id) {
            $('#add-stok-kitchen .modal-title').text('Input Stok Kitchen: ' + nama);
            $('#add-stok-kitchen #add-bahan_id').val(bahanId);
            $('#add-stok-kitchen #add-jumlah_min').val(jumlah_min);
            $('#add-stok-kitchen #add-status_input').val('+');
            $('#add-stok-kitchen #add-status').val('-');
            $('#add-stok-kitchen #add-tanggal').val(new Date().toISOString().split('T')[0]);
            $('#add-stok-kitchen #form-stok-kitchen').attr('action', '{{ route('stok-kitchen.store') }}');

            // Show field jumlah untuk mode tambah bahan
            $('#add-stok-kitchen #jumlah-field').show();
            $('#add-stok-kitchen #add-jumlah').val('');
            $('#add-stok-kitchen #add-jumlah').attr('required', 'required');

            // Make jumlah_real readonly untuk mode tambah bahan
            $('#add-stok-kitchen #add-jumlah_real').prop('readonly', true);
            $('#add-stok-kitchen #add-jumlah_real').val('');

            $('#add-stok-kitchen').modal('show');
        }

        function showInputStokKitchen(bahanId, nama, jumlah_min, stok_gudang_id) {
            $('#add-stok-kitchen .modal-title').text('Sisa Stok Kitchen: ' + nama);
            $('#add-stok-kitchen #add-bahan_id').val(bahanId);
            $('#add-stok-kitchen #add-jumlah_min').val(jumlah_min);
            $('#add-stok-kitchen #add-status_input').val('-');
            $('#add-stok-kitchen #add-status').val('-');
            $('#add-stok-kitchen #add-tanggal').val(new Date().toISOString().split('T')[0]);
            $('#add-stok-kitchen #form-stok-kitchen').attr('action', '{{ route('stok-kitchen.store') }}');

            // Set jumlah = 0 dan hide field jumlah
            $('#add-stok-kitchen #add-jumlah').val(0);
            $('#add-stok-kitchen #add-jumlah').removeAttr('required');
            $('#add-stok-kitchen #jumlah-field').hide();

            // Make jumlah_real editable dan clear valuenya
            $('#add-stok-kitchen #add-jumlah_real').prop('readonly', false);
            $('#add-stok-kitchen #add-jumlah_real').val('');

            $('#add-stok-kitchen').modal('show');
        }

        // Update jumlah_real setiap kali jumlah atau jumlah_min berubah (hanya untuk mode tambah bahan)
        $(document).on('input', '#add-jumlah, #add-jumlah_min', function() {
            // Hanya update jika jumlah_real dalam mode readonly (mode tambah bahan)
            if ($('#add-jumlah_real').prop('readonly')) {
                let jumlah = parseInt($('#add-jumlah').val()) || 0;
                let jumlah_min = parseInt($('#add-jumlah_min').val()) || 0;
                $('#add-jumlah_real').val(jumlah * jumlah_min);
            }
        });
    </script>

@endsection
