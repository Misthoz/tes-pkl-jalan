@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Detail Pengguna</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="30%">ID</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Username</th>
                <td><code>{{ $user->username }}</code></td>
            </tr>
            <tr>
                <th>Role</th>
                <td>
                    @if($user->isAdmin())
                        <span class="badge bg-danger">Admin</span>
                    @else
                        <span class="badge bg-info">Petugas</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Dibuat</th>
                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Terakhir Diperbarui</th>
                <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>

        <div class="mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection
