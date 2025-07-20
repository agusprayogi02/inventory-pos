@extends('adminlte::page')

@section('title', 'Detail Stok Gudang ' . ($bahan->nama ?? ''))
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.Select2', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Detail Stok Bahan <b>{{ $bahan->nama ?? '' }}</b></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('adminlte::menu.home') }}</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('stok-gudang.index') }}">{{ __('adminlte::menu.stok_gudang') }}</a></li>
                <li class="breadcrumb-item active">Detail Stok Bahan {{ $bahan->nama ?? '' }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <x-adminlte-modal id="modal-minus-stok-gudang" title="Kurangi Stok" size="md">
        <form action="{{ route('stok-gudang.kurangi') }}" method="post" id="form-stok-gudang">
            @csrf
            <input type="hidden" name="stok_gudang_ref" id="add-stok_gudang_ref_input">
            <input type="hidden" name="changed_id" id="add-changed_id_input">
            <div id="group-sisa-stok">
                <x-adminlte.form.input name="sisa_stok" id="add-sisa-stok" label="Sisa Stok" type="number"
                    placeholder="Sisa Stok" readonly />
            </div>
            <x-adminlte.form.input name="jumlah" id="add-jumlah" label="Jumlah" type="number" placeholder="Jumlah"
                required />
            <x-adminlte.form.input name="tanggal" id="add-tanggal" label="Tanggal" type="date" placeholder="Tanggal"
                required />
            <x-adminlte.form.textarea name="keterangan" id="add-keterangan" label="Keterangan" placeholder="Keterangan" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" theme="success" label="Submit" form="form-stok-gudang" />
                <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('stok-gudang.index') }}" class="btn btn-success mr-4">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <x-adminlte.tool.datatable id="stok-gudang-detail-tables" :heads="['Tanggal', 'Exp Date', 'Status', 'Jumlah', 'User', 'Aksi']" :config="[
                        'columns' => [
                            ['data' => 'tanggal'],
                            ['data' => 'exp_date'],
                            ['data' => 'status'],
                            ['data' => 'jumlah'],
                            ['data' => 'user'],
                            ['data' => 'action', 'orderable' => false, 'searchable' => false],
                        ],
                        'processing' => true,
                        'serverSide' => true,
                        'ajax' => [
                            'url' => route('stok-gudang.dataDetail', $bahan->id),
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
        function minusStokGudang(id, sisaStok) {
            $('#add-stok_gudang_ref_input').val(id);
            $('#add-sisa-stok').val(sisaStok);

            $('#modal-minus-stok-gudang').modal('show');
        }

        function changeStokGudang(id, sisaStok, changedId, jumlah, tanggal, keterangan) {
            // change title to edit stok
            $('#modal-minus-stok-gudang').find('.modal-title').text('Edit Stok Gudang');
            $('#add-stok_gudang_ref_input').val(id);
            $('#group-sisa-stok').addClass('d-none');
            $('#add-changed_id_input').val(changedId);
            $('#add-jumlah').val(jumlah);
            $('#add-tanggal').val(tanggal);
            $('#add-keterangan').val(keterangan);

            $('#modal-minus-stok-gudang').modal('show');
        }
    </script>
@endsection
