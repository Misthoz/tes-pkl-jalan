@extends('layouts.app')

@section('title', 'Detail Jalan')

@php
    $errDok = $errors->getBag('dokumentasi');
    $errRiwayat = $errors->getBag('riwayat');
@endphp

@section('styles')
@if($jalan->latitude && $jalan->longitude)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map-detail { height: 300px; border-radius: 8px; border: 1px solid #dee2e6; }
</style>
@endif
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Detail Jalan Lingkungan</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">ID</th>
                        <td>{{ $jalan->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Jalan</th>
                        <td>{{ $jalan->nama_jalan }}</td>
                    </tr>
                    <tr>
                        <th>Kelurahan</th>
                        <td>{{ $jalan->kelurahan->nama_kelurahan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td>{{ $jalan->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Panjang</th>
                        <td>{{ $jalan->panjang_meter }} Meter</td>
                    </tr>
                    <tr>
                        <th>Lebar</th>
                        <td>{{ $jalan->lebar_meter }} Meter</td>
                    </tr>
                    <tr>
                        <th>Jenis Permukaan</th>
                        <td>{{ $jalan->jenis_permukaan }}</td>
                    </tr>
                    <tr>
                        <th>Kondisi</th>
                        <td>
                            @if($jalan->kondisi == 'Baik')
                                <span class="badge bg-success">Baik</span>
                            @elseif($jalan->kondisi == 'Rusak Ringan')
                                <span class="badge bg-warning text-dark">Rusak Ringan</span>
                            @else
                                <span class="badge bg-danger">Rusak Berat</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tahun Pendataan</th>
                        <td>{{ $jalan->tahun_pendataan }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($jalan->keterangan)
        <div class="mt-3">
            <h6>Keterangan:</h6>
            <div class="p-3 bg-light rounded border">
                {{ $jalan->keterangan }}
            </div>
        </div>
        @endif

        @if($jalan->latitude && $jalan->longitude)
        <div class="mt-4">
            <h6>Lokasi di Peta:</h6>
            <div id="map-detail"></div>
            <small class="text-muted">Koordinat: {{ $jalan->latitude }}, {{ $jalan->longitude }}</small>
        </div>
        @endif

        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Dokumentasi Foto</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahFoto">
                    Tambah Foto
                </button>
            </div>
            @if($jalan->dokumentasi->count() > 0)
                <div class="row g-3">
                    @foreach($jalan->dokumentasi as $dok)
                        <div class="col-md-4 col-lg-3">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . $dok->foto) }}" class="card-img-top" alt="Dokumentasi" style="height: 200px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <small class="text-muted d-block">{{ \Carbon\Carbon::parse($dok->tanggal_dokumentasi)->format('d/m/Y') }}</small>
                                    <small>{{ $dok->keterangan ?? '-' }}</small>
                                </div>
                                <div class="card-footer p-2">
                                    <form action="{{ route('dokumentasi.destroy', $dok->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin menghapus foto ini?')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-light border">Belum ada dokumentasi foto.</div>
            @endif
        </div>

        <div class="modal fade" id="modalTambahFoto" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('dokumentasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jalan_id" value="{{ $jalan->id }}">
                        <input type="hidden" name="_error_bag" value="dokumentasi">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Foto Dokumentasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @if($errDok->any())
                                <div class="alert alert-danger">
                                    <strong>Upload gagal.</strong> Perbaiki hal berikut:
                                    <ul class="mb-0 mt-2">
                                        @foreach($errDok->all() as $pesan)
                                            <li>{{ $pesan }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Foto <span class="text-danger">*</span></label>
                                <input type="file" name="foto" class="form-control @error('foto', 'dokumentasi') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/webp" required>
                                @error('foto', 'dokumentasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPEG, PNG, JPG, WebP. Maks 2MB.</small>
                                @if($errDok->any())
                                    <div class="text-danger"><small>Foto harus dipilih ulang.</small></div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Dokumentasi <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_dokumentasi" class="form-control @error('tanggal_dokumentasi', 'dokumentasi') is-invalid @enderror" value="{{ $errDok->any() ? old('tanggal_dokumentasi', date('Y-m-d')) : date('Y-m-d') }}" required>
                                @error('tanggal_dokumentasi', 'dokumentasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" rows="2" class="form-control @error('keterangan', 'dokumentasi') is-invalid @enderror">{{ $errDok->any() ? old('keterangan') : '' }}</textarea>
                                @error('keterangan', 'dokumentasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Riwayat Kondisi Jalan</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahRiwayat">
                    Tambah Riwayat
                </button>
            </div>
            @if($jalan->riwayatKondisi->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Survei</th>
                                <th>Kondisi</th>
                                <th>Keterangan</th>
                                <th>Dicatat Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jalan->riwayatKondisi->sortByDesc('tanggal_survei') as $riwayat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_survei)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($riwayat->kondisi == 'Baik')
                                            <span class="badge bg-success">Baik</span>
                                        @elseif($riwayat->kondisi == 'Rusak Ringan')
                                            <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                        @else
                                            <span class="badge bg-danger">Rusak Berat</span>
                                        @endif
                                    </td>
                                    <td>{{ $riwayat->keterangan ?? '-' }}</td>
                                    <td>{{ $riwayat->user->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-light border">Belum ada riwayat kondisi.</div>
            @endif
        </div>

        <div class="modal fade" id="modalTambahRiwayat" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('riwayat-kondisi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="jalan_id" value="{{ $jalan->id }}">
                        <input type="hidden" name="_error_bag" value="riwayat">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Riwayat Kondisi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @if($errRiwayat->any())
                                <div class="alert alert-danger">
                                    <strong>Gagal menyimpan.</strong> Perbaiki hal berikut:
                                    <ul class="mb-0 mt-2">
                                        @foreach($errRiwayat->all() as $pesan)
                                            <li>{{ $pesan }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Tanggal Survei <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_survei" class="form-control @error('tanggal_survei', 'riwayat') is-invalid @enderror" value="{{ $errRiwayat->any() ? old('tanggal_survei', date('Y-m-d')) : date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                                @error('tanggal_survei', 'riwayat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Tidak boleh di masa depan.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                                <select name="kondisi" class="form-select @error('kondisi', 'riwayat') is-invalid @enderror" required>
                                    <option value="">Pilih Kondisi</option>
                                    @php
                                        $kondisiLama = $errRiwayat->any() ? old('kondisi') : null;
                                    @endphp
                                    <option value="Baik" {{ $kondisiLama == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ $kondisiLama == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ $kondisiLama == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi', 'riwayat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" rows="2" class="form-control @error('keterangan', 'riwayat') is-invalid @enderror">{{ $errRiwayat->any() ? old('keterangan') : '' }}</textarea>
                                @error('keterangan', 'riwayat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('jalan.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('jalan.edit', $jalan->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($errDok->any() || $errRiwayat->any())
<script>
    new bootstrap.Modal(document.getElementById('{{ $errDok->any() ? 'modalTambahFoto' : 'modalTambahRiwayat' }}')).show();
</script>
@endif
@if($jalan->latitude && $jalan->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map-detail').setView([{{ $jalan->latitude }}, {{ $jalan->longitude }}], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    L.marker([{{ $jalan->latitude }}, {{ $jalan->longitude }}])
        .addTo(map)
        .bindPopup('<strong>{{ $jalan->nama_jalan }}</strong>')
        .openPopup();
</script>
@endif
@endsection
