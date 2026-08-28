@extends('layouts.app')

@section('title', 'Peta Sebaran Jalan')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #peta-sebaran { height: 600px; border-radius: 8px; border: 1px solid #dee2e6; }
    .legend { padding: 8px; background: white; border-radius: 5px; box-shadow: 0 1px 5px rgba(0,0,0,.3); line-height: 24px; }
    .legend i { width: 14px; height: 14px; display: inline-block; margin-right: 6px; border-radius: 50%; vertical-align: middle; }
</style>
@endsection

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form action="{{ route('peta.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Kecamatan</label>
                <select name="kecamatan_id" id="filter_kecamatan" class="form-select">
                    <option value="">Semua Kecamatan</option>
                    @foreach($kecamatan as $kec)
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
                    @foreach($kecamatan as $kec)
                        @foreach($kec->kelurahan as $kel)
                            <option value="{{ $kel->id }}" data-kecamatan="{{ $kec->id }}" {{ request('kelurahan_id') == $kel->id ? 'selected' : '' }}>
                                {{ $kel->nama_kelurahan }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kondisi</label>
                <select name="kondisi" class="form-select">
                    <option value="Semua" {{ request('kondisi') == 'Semua' ? 'selected' : '' }}>Semua</option>
                    <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100 mb-1">Filter</button>
                <a href="{{ route('peta.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Peta Sebaran Jalan <span class="badge bg-secondary">{{ $jalanData->count() }} titik</span></h5>
    </div>
    <div class="card-body">
        <div id="peta-sebaran"></div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const filterKecamatan = document.getElementById('filter_kecamatan');
    const filterKelurahan = document.getElementById('filter_kelurahan');
    const allKelurahanOptions = [...filterKelurahan.querySelectorAll('option[data-kecamatan]')];

    function filterKelurahanByKecamatan() {
        const kecId = filterKecamatan.value;
        filterKelurahan.querySelectorAll('option[data-kecamatan]').forEach(opt => {
            opt.style.display = (!kecId || opt.dataset.kecamatan === kecId) ? '' : 'none';
        });
        if (kecId) {
            const selectedOpt = filterKelurahan.querySelector('option[data-kecamatan]:checked');
            if (selectedOpt && selectedOpt.dataset.kecamatan !== kecId) {
                filterKelurahan.value = '';
            }
        }
    }
    filterKecamatan.addEventListener('change', filterKelurahanByKecamatan);
    filterKelurahanByKecamatan();

    const map = L.map('peta-sebaran').setView([-0.5022, 117.1536], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    function getMarkerColor(kondisi) {
        switch(kondisi) {
            case 'Baik': return '#198754';
            case 'Rusak Ringan': return '#ffc107';
            case 'Rusak Berat': return '#dc3545';
            default: return '#6c757d';
        }
    }

    function createCircleMarker(lat, lng, kondisi) {
        return L.circleMarker([lat, lng], {
            radius: 8,
            fillColor: getMarkerColor(kondisi),
            color: '#fff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.8
        });
    }

    function popupText(value) {
        return (value === null || value === undefined || value === '') ? '-' : String(value);
    }
    function appendPopupRow(parent, label, value, boldValue) {
        const row = document.createElement('small');
        row.append(label);

        if (boldValue) {
            const strong = document.createElement('strong');
            strong.textContent = popupText(value);
            row.appendChild(strong);
        } else {
            row.append(popupText(value));
        }

        parent.appendChild(row);
        parent.appendChild(document.createElement('br'));
    }

    function createPopupContent(jalan) {
        const wrapper = document.createElement('div');

        const nama = document.createElement('strong');
        nama.textContent = popupText(jalan.nama_jalan);
        wrapper.appendChild(nama);
        wrapper.appendChild(document.createElement('br'));

        appendPopupRow(wrapper, 'Kelurahan: ', jalan.kelurahan ? jalan.kelurahan.nama_kelurahan : null);
        appendPopupRow(wrapper, 'Kecamatan: ', (jalan.kelurahan && jalan.kelurahan.kecamatan) ? jalan.kelurahan.kecamatan.nama_kecamatan : null);
        appendPopupRow(wrapper, 'Kondisi: ', jalan.kondisi, true);

        const panjang = document.createElement('small');
        panjang.append('Panjang: ' + popupText(jalan.panjang_meter) + ' m');
        wrapper.appendChild(panjang);

        return wrapper;
    }

    const jalanData = @json($jalanData);
    const bounds = [];

    jalanData.forEach(function(jalan) {
        const marker = createCircleMarker(jalan.latitude, jalan.longitude, jalan.kondisi);
        marker.bindPopup(createPopupContent(jalan));
        marker.addTo(map);
        bounds.push([jalan.latitude, jalan.longitude]);
    });

    if (bounds.length > 0) {
        map.fitBounds(bounds, { padding: [30, 30] });
    }

    const legend = L.control({ position: 'bottomright' });
    legend.onAdd = function() {
        const div = L.DomUtil.create('div', 'legend');
        div.innerHTML = '<strong>Kondisi</strong><br>' +
            '<i style="background:#198754"></i> Baik<br>' +
            '<i style="background:#ffc107"></i> Rusak Ringan<br>' +
            '<i style="background:#dc3545"></i> Rusak Berat';
        return div;
    };
    legend.addTo(map);
</script>
@endsection
