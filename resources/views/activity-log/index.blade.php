    @extends('adminlte::page')

    @section('title', 'Activity Log')
    @section('plugins.Datatables', true)
    @section('plugins.DatatablesPlugins', true)
    @section('plugins.Select2', true)

    @section('content_header')
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('adminlte::menu.activity_log') }}</h1>
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <x-adminlte.tool.datatable id="activity-log-tables" :heads="['Causer', 'Description', 'Created At']" :config="[
                            'columns' => [['data' => 'causer'], ['data' => 'description'], ['data' => 'created_at']],
                            'processing' => true,
                            'serverSide' => true,
                            'ajax' => [
                                'url' => route('activity-log.data'),
                                'type' => 'GET',
                            ],
                            'pageLength' => 10,
                            'responsive' => true,
                        ]" />
                    </div>
                </div>
            </div>
        </div>
    @endsection
