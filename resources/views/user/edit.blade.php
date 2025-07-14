@extends('adminlte::page')

@section('title', 'Edit User')
@section('plugins.Select2', true)

@section('content_header')
    <h1>Edit User</h1>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-adminlte.form.input name="name" label="Nama" type="text" :value="old('name', $user->name)" required />
                        <x-adminlte.form.input name="email" label="Email" type="email" :value="old('email', $user->email)" required />
                        <x-adminlte.form.input name="password" label="Password (kosongkan jika tidak ingin diubah)"
                            type="password" />
                        <x-adminlte.form.input name="password_confirmation" label="Konfirmasi Password" type="password" />
                        <div class="form-group">
                            <label for="roles">Roles</label>
                            <select name="roles[]" class="form-control select2" multiple required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <x-adminlte.form.button type="submit" theme="primary" label="Update" />
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
