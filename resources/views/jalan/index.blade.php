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

{{-- Filter & Pencarian --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('jalan.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Cari Nama Jalan</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nama jalan...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kecamatan</label>
                    <select name="kecamatan_id" id="filter_kecamatan" class="form-select">
                        <option value="">Semua Kecamatan</option>
                        @foreach($kecamatanList as $kec)
                            <option value="{{ $kec->id }}" {{ request('kecamatan_id') == $kec->id ? 'selected' : '' }}>
                                {{ $kec->nama_kecamatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kelurahan</label>
                    <select name="kelurahan_id" id="filter_kelurahan" class="form-select">
                        <option value="">Semua Kelurahan</option>
                        @foreach($kecamatanList as $kec)
                            @foreach($kec->kelurahan as $kel)
                                <option value="{{ $kel->id }}" data-kecamatan="{{ $kec->id }}" {{ request('kelurahan_id') == $kel->id ? 'selected' : '' }}>
                                    {{ $kel->nama_kelurahan }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
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
            </div>
            <div class="row g-3 mt-1 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Permukaan</label>
                    <select name="jenis_permukaan" class="form-select">
                        <option value="Semua" {{ request('jenis_permukaan') == 'Semua' ? 'selected' : '' }}>Semua</option>
                        <option value="Aspal" {{ request('jenis_permukaan') == 'Aspal' ? 'selected' : '' }}>Aspal</option>
                        <option value="Beton" {{ request('jenis_permukaan') == 'Beton' ? 'selected' : '' }}>Beton</option>
                        <option value="Paving" {{ request('jenis_permukaan') == 'Paving' ? 'selected' : '' }}>Paving</option>
                        <option value="Tanah" {{ request('jenis_permukaan') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tahun</label>
                    <select name="tahun_pendataan" class="form-select">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun_pendataan') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Panjang Min (m)</label>
                    <input type="number" name="panjang_min" class="form-control" value="{{ request('panjang_min') }}" placeholder="Min" min="0">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Panjang Max (m)</label>
                    <input type="number" name="panjang_max" class="form-control" value="{{ request('panjang_max') }}" placeholder="Max" min="0">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Urutkan</label>
                    <select name="sort_by" class="form-select">
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                        <option value="nama_jalan" {{ request('sort_by') == 'nama_jalan' ? 'selected' : '' }}>Nama Jalan</option>
                        <option value="panjang_meter" {{ request('sort_by') == 'panjang_meter' ? 'selected' : '' }}>Panjang</option>
                        <option value="kondisi" {{ request('sort_by') == 'kondisi' ? 'selected' : '' }}>Kondisi</option>
                    </select>
                    <select name="sort_dir" class="form-select mt-1">
                        <option value="desc" {{ request('sort_dir', 'desc') == 'desc' ? 'selected' : '' }}>Menurun</option>
                        <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Menaik</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 mb-1">Cari / Filter</button>
                    <a href="{{ route('jalan.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0">Data Jalan Lingkungan <span class="badge bg-secondary ms-2">Total Panjang: {{ number_format($summary['total_panjang'] / 1000, 2, ',', '.') }} km</span></h5>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('export.pdf', request()->query()) }}" class="btn btn-danger btn-sm">Export PDF</a>
            <a href="{{ route('export.excel', request()->query()) }}" class="btn btn-success btn-sm">Export Excel</a>
            <a href="{{ route('jalan.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
        </div>
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
                            <td>{{ $item->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td>{{ $item->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
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

@section('scripts')
<script>
    const filterKecamatan = document.getElementById('filter_kecamatan');
    const filterKelurahan = document.getElementById('filter_kelurahan');

    function filterKelurahanByKecamatan() {
        const kecId = filterKecamatan.value;
        filterKelurahan.querySelectorAll('option[data-kecamatan]').forEach(opt => {
            opt.style.display = (!kecId || opt.dataset.kecamatan === kecId) ? '' : 'none';
        });
        if (kecId) {
            const selectedOpt = filterKelurahan.querySelector('option:checked');
            if (selectedOpt && selectedOpt.dataset.kecamatan && selectedOpt.dataset.kecamatan !== kecId) {
                filterKelurahan.value = '';
            }
        }
    }

    filterKecamatan.addEventListener('change', filterKelurahanByKecamatan);
    filterKelurahanByKecamatan();
</script>
@endsection
