@extends('layouts.app')

@section('title', 'Edit Data Kelurahan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Edit Data Kelurahan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('kelurahan.update', $kelurahan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nama Kelurahan <span class="text-danger">*</span></label>
                <input type="text" name="nama_kelurahan" class="form-control @error('nama_kelurahan') is-invalid @enderror" value="{{ old('nama_kelurahan', $kelurahan->nama_kelurahan) }}" required>
                @error('nama_kelurahan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                <select name="kecamatan_id" class="form-select @error('kecamatan_id') is-invalid @enderror" required>
                    <option value="">Pilih Kecamatan</option>
                    @foreach ($kecamatan as $k)
                        <option value="{{ $k->id }}" {{ old('kecamatan_id', $kelurahan->kecamatan_id) == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kecamatan }}
                        </option>
                    @endforeach
                </select>
                @error('kecamatan_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('kelurahan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection