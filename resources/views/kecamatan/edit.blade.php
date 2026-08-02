@extends('layouts.app')

@section('title', 'Edit Data Kecamatan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Edit Data Kecamatan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('kecamatan.update', $kecamatan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nama Kecamatan <span class="text-danger">*</span></label>
                <input type="text" name="nama_kecamatan" class="form-control @error('nama_kecamatan') is-invalid @enderror" value="{{ old('nama_kecamatan', $kecamatan->nama_kecamatan) }}" required>
                @error('nama_kecamatan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('kecamatan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection