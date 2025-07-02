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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('stok-gudang.index') }}" class="btn btn-success mr-4">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <x-adminlte.tool.datatable id="stok-gudang-detail-tables" :heads="['ID', 'Tanggal', 'Exp Date', 'Status', 'Jumlah', 'User']" :config="[
                        'columns' => [
                            ['data' => 'id'],
                            ['data' => 'tanggal'],
                            ['data' => 'exp_date'],
                            ['data' => 'status'],
                            ['data' => 'jumlah'],
                            ['data' => 'user'],
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
