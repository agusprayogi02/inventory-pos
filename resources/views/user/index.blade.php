@extends('adminlte::page')

@section('title', 'User Management')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.Select2', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>User Management</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">User Management</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah User</a>
                </div>
                <div class="card-body">
                    <x-adminlte.tool.datatable id="user-tables" :heads="['ID', 'Nama', 'Email', 'Roles', 'Aksi']" :config="[
                        'ajax' => route('user.data'),
                        'columns' => [
                            ['data' => 'id'],
                            ['data' => 'name'],
                            ['data' => 'email'],
                            ['data' => 'roles'],
                            ['data' => 'action', 'orderable' => false, 'searchable' => false],
                        ],
                        'processing' => true,
                        'serverSide' => false,
                        'pageLength' => 10,
                        'responsive' => true,
                    ]" />
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        function deleteUser(id) {
            Swal.fire({
                title: 'Yakin hapus user?',
                text: "Data user yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ url('master/user') }}/' + id;
                    var csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    var method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
