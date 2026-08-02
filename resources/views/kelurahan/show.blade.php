@extends('layouts.app')

@section('title', 'Detail Kelurahan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Detail Kelurahan</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="30%">ID</th>
                <td>{{ $kelurahan->id }}</td>
            </tr>
            <tr>
                <th>Nama Kelurahan</th>
                <td>{{ $kelurahan->nama_kelurahan }}</td>
            </tr>
            <tr>
                <th>Kecamatan</th>
                <td>{{ $kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Total Jalan</th>
                <td>{{ $kelurahan->jalan()->count() }}</td>
            </tr>
        </table>
        
        <div class="mt-4">
            <a href="{{ route('kelurahan.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('kelurahan.edit', $kelurahan->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection
