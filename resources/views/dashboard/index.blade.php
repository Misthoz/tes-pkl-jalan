@extends('layouts.app')

@section('title', 'Dashboard - Sistem Pendataan Jalan')

@section('content')
{{-- Filter Wilayah --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('dashboard') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Filter Kecamatan</label>
                <select name="kecamatan_id" id="dash_kecamatan" class="form-select">
                    <option value="">Semua Kecamatan</option>
                    @foreach($kecamatan as $kec)
                        <option value="{{ $kec->id }}" {{ request('kecamatan_id') == $kec->id ? 'selected' : '' }}>
                            {{ $kec->nama_kecamatan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Filter Kelurahan</label>
                <select name="kelurahan_id" id="dash_kelurahan" class="form-select">
                    <option value="">Semua Kelurahan</option>
                    @foreach($kecamatan as $kec)
                        @foreach($kec->kelurahan as $kel)
                            <option value="{{ $kel->id }}" data-kecamatan="{{ $kec->id }}" {{ request('kelurahan_id') == $kel->id ? 'selected' : '' }}>
                                {{ $kel->nama_kelurahan }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100 mb-1">Filter</button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Kartu Ringkasan --}}
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm bg-primary text-white h-100">
            <div class="card-body">
                <h6 class="card-title">Total Jalan</h6>
                <h3 class="mb-0">{{ $stats['total_jalan'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm bg-success text-white h-100">
            <div class="card-body">
                <h6 class="card-title">Kondisi Baik</h6>
                <h3 class="mb-0">{{ $stats['kondisi_baik'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm bg-warning text-dark h-100">
            <div class="card-body">
                <h6 class="card-title">Rusak Ringan</h6>
                <h3 class="mb-0">{{ $stats['kondisi_rusak_ringan'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm bg-danger text-white h-100">
            <div class="card-body">
                <h6 class="card-title">Rusak Berat</h6>
                <h3 class="mb-0">{{ $stats['kondisi_rusak_berat'] }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Total Panjang Jalan</h6>
                <h2 class="text-primary mb-0">{{ number_format($stats['total_panjang'] / 1000, 2, ',', '.') }} km</h2>
                <small class="text-muted">({{ number_format($stats['total_panjang'], 0, ',', '.') }} meter)</small>
            </div>
        </div>
    </div>
</div>

{{-- Grafik --}}
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0">Grafik Kondisi Jalan</h6>
            </div>
            <div class="card-body">
                <canvas id="chartKondisi" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0">Grafik Jenis Permukaan</h6>
            </div>
            <div class="card-body">
                <canvas id="chartPermukaan" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Kecamatan Jalan Rusak Terbanyak --}}
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Kecamatan dengan Jalan Rusak Terbanyak</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kecamatan</th>
                                <th>Jumlah Jalan Rusak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kecamatanRusakTerbanyak as $kec)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kec->nama_kecamatan }}</td>
                                    <td>
                                        <span class="badge bg-danger">{{ $kec->jalan_rusak_count }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">Tidak ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    // Dependent dropdown
    const dKec = document.getElementById('dash_kecamatan');
    const dKel = document.getElementById('dash_kelurahan');
    function filterDashKel() {
        const kecId = dKec.value;
        dKel.querySelectorAll('option[data-kecamatan]').forEach(opt => {
            opt.style.display = (!kecId || opt.dataset.kecamatan === kecId) ? '' : 'none';
        });

        if (kecId) {
            const selectedOpt = dKel.querySelector('option[data-kecamatan]:checked');
            if (selectedOpt && selectedOpt.dataset.kecamatan !== kecId) {
                dKel.value = '';
            }
        }
    }
    dKec.addEventListener('change', filterDashKel);
    filterDashKel();

    const kondisiData = @json($grafikKondisi);
    new Chart(document.getElementById('chartKondisi'), {
        type: 'doughnut',
        data: {
            labels: kondisiData.map(d => d.label),
            datasets: [{
                data: kondisiData.map(d => d.value),
                backgroundColor: kondisiData.map(d => d.color),
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    const permukaanData = @json($grafikPermukaan);
    const permukaanColors = { 'Aspal': '#0d6efd', 'Beton': '#6c757d', 'Paving': '#0dcaf0', 'Tanah': '#d4a373' };
    new Chart(document.getElementById('chartPermukaan'), {
        type: 'bar',
        data: {
            labels: Object.keys(permukaanData),
            datasets: [{
                label: 'Jumlah Jalan',
                data: Object.values(permukaanData),
                backgroundColor: Object.keys(permukaanData).map(k => permukaanColors[k] || '#6c757d'),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endsection
