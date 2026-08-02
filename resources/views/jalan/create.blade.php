@extends('layouts.app')

@section('title', 'Tambah Data Jalan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Tambah Data Jalan Lingkungan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('jalan.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Jalan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_jalan" class="form-control @error('nama_jalan') is-invalid @enderror" value="{{ old('nama_jalan') }}" required maxlength="150">
                    @error('nama_jalan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kelurahan <span class="text-danger">*</span></label>
                    <select name="kelurahan_id" class="form-select @error('kelurahan_id') is-invalid @enderror" required>
                        <option value="">Pilih Kelurahan</option>
                        @foreach ($kelurahan as $k)
                            <option value="{{ $k->id }}" {{ old('kelurahan_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelurahan }} (Kec. {{ $k->kecamatan->nama_kecamatan }})
                            </option>
                        @endforeach
                    </select>
                    @error('kelurahan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Panjang (Meter) <span class="text-danger">*</span></label>
                    <input type="number" name="panjang_meter" class="form-control @error('panjang_meter') is-invalid @enderror" value="{{ old('panjang_meter') }}" required min="1">
                    @error('panjang_meter') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lebar (Meter) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="lebar_meter" class="form-control @error('lebar_meter') is-invalid @enderror" value="{{ old('lebar_meter') }}" required min="0.01">
                    @error('lebar_meter') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Jenis Permukaan <span class="text-danger">*</span></label>
                    <select name="jenis_permukaan" class="form-select @error('jenis_permukaan') is-invalid @enderror" required>
                        <option value="">Pilih Jenis</option>
                        <option value="Aspal" {{ old('jenis_permukaan') == 'Aspal' ? 'selected' : '' }}>Aspal</option>
                        <option value="Beton" {{ old('jenis_permukaan') == 'Beton' ? 'selected' : '' }}>Beton</option>
                        <option value="Paving" {{ old('jenis_permukaan') == 'Paving' ? 'selected' : '' }}>Paving</option>
                        <option value="Tanah" {{ old('jenis_permukaan') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                    </select>
                    @error('jenis_permukaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                    <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                        <option value="">Pilih Kondisi</option>
                        <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                    @error('kondisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tahun Pendataan <span class="text-danger">*</span></label>
                    <input type="number" name="tahun_pendataan" class="form-control @error('tahun_pendataan') is-invalid @enderror" value="{{ old('tahun_pendataan', date('Y')) }}" required min="2000" max="{{ date('Y') }}">
                    @error('tahun_pendataan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('jalan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection