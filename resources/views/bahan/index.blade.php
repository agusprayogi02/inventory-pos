@extends('adminlte::page')

@section('title', 'Bahan')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.Select2', true)

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
