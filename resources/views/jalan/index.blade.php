@extends('layouts.app')

@section('title', 'Data Jalan Lingkungan')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm bg-primary text-white h-100">
            <div class="card-body">
                <h6 class="card-title">Total Jalan</h6>
                <h3 class="mb-0">{{ $summary['total_jalan'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm bg-success text-white h-100">
            <div class="card-body">
                <h6 class="card-title">Kondisi Baik</h6>
                <h3 class="mb-0">{{ $summary['kondisi_baik'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm bg-warning text-dark h-100">
            <div class="card-body">
                <h6 class="card-title">Rusak Ringan</h6>
                <h3 class="mb-0">{{ $summary['kondisi_rusak_ringan'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm bg-danger text-white h-100">
            <div class="card-body">
                <h6 class="card-title">Rusak Berat</h6>
                <h3 class="mb-0">{{ $summary['kondisi_rusak_berat'] }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('jalan.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Cari Nama Jalan</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari">
            </div>
            <div class="col-md-3">
                <label class="form-label">Filter Kondisi</label>
                <select name="kondisi" class="form-select">
                    <option value="Semua" {{ request('kondisi') == 'Semua' ? 'selected' : '' }}>Semua</option>
                    <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Filter Permukaan</label>
                <select name="jenis_permukaan" class="form-select">
                    <option value="Semua" {{ request('jenis_permukaan') == 'Semua' ? 'selected' : '' }}>Semua</option>
                    <option value="Aspal" {{ request('jenis_permukaan') == 'Aspal' ? 'selected' : '' }}>Aspal</option>
                    <option value="Beton" {{ request('jenis_permukaan') == 'Beton' ? 'selected' : '' }}>Beton</option>
                    <option value="Paving" {{ request('jenis_permukaan') == 'Paving' ? 'selected' : '' }}>Paving</option>
                    <option value="Tanah" {{ request('jenis_permukaan') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 mb-1">Cari / Filter</button>
                <a href="{{ route('jalan.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Jalan Lingkungan <span class="badge bg-secondary ms-2">Total Panjang: {{ number_format($summary['total_panjang'] / 1000, 2, ',', '.') }} km</span></h5>
        <a href="{{ route('jalan.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Jalan</th>
                        <th>Kelurahan</th>
                        <th>Kecamatan</th>
                        <th>Panjang (m)</th>
                        <th>Lebar (m)</th>
                        <th>Permukaan</th>
                        <th>Kondisi</th>
                        <th>Tahun</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td>{{ $data->firstItem() + $loop->index }}</td>
                            <td>{{ $item->nama_jalan }}</td>
                            <td>{{ $item->kelurahan->nama_kelurahan }}</td>
                            <td>{{ $item->kelurahan->kecamatan->nama_kecamatan }}</td>
                            <td>{{ number_format($item->panjang_meter, 0, ',', '.') }} m</td>
                            <td>{{ $item->lebar_meter }} m</td>
                            <td>{{ $item->jenis_permukaan }}</td>
                            <td>
                                @if($item->kondisi == 'Baik')
                                    <span class="badge bg-success">Baik</span>
                                @elseif($item->kondisi == 'Rusak Ringan')
                                    <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                @else
                                    <span class="badge bg-danger">Rusak Berat</span>
                                @endif
                            </td>
                            <td>{{ $item->tahun_pendataan }}</td>
                            <td>
                                <a href="{{ route('jalan.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('jalan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('jalan.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
