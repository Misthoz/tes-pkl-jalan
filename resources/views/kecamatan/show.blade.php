@extends('layouts.app')

@section('title', 'Detail Kecamatan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Detail Kecamatan</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="30%">ID</th>
                <td>{{ $kecamatan->id }}</td>
            </tr>
            <tr>
                <th>Nama Kecamatan</th>
                <td>{{ $kecamatan->nama_kecamatan }}</td>
            </tr>
            <tr>
                <th>Total Kelurahan</th>
                <td>{{ $kecamatan->kelurahan()->count() }}</td>
            </tr>
        </table>
        
        <div class="mt-4">
            <a href="{{ route('kecamatan.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('kecamatan.edit', $kecamatan->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection
