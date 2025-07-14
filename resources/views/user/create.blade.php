@extends('adminlte::page')

@section('title', 'Tambah User')
@section('plugins.Select2', true)

@section('content_header')
    <h1>Tambah User</h1>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <x-adminlte.form.input name="name" label="Nama" type="text" :value="old('name')" required />
                        <x-adminlte.form.input name="email" label="Email" type="email" :value="old('email')" required />
                        <x-adminlte.form.input name="password" label="Password" type="password" required />
                        <x-adminlte.form.input name="password_confirmation" label="Konfirmasi Password" type="password"
                            required />
                        <div class="form-group">
                            <label for="roles">Roles</label>
                            <select name="roles[]" class="form-control select2" multiple required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <x-adminlte.form.button type="submit" theme="primary" label="Simpan" />
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
