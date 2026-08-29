@extends('layouts.app')

@section('title', 'Data Terhapus (Trash)')

@section('content')
@php
    $activeTab = request()->has('page_kecamatan')
        ? 'kecamatan'
        : (request()->has('page_kelurahan') ? 'kelurahan' : 'jalan');
@endphp

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-3">Data Terhapus (Sampah)</h5>
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'jalan' ? 'active' : '' }}" type="button"
                        data-bs-toggle="tab" data-bs-target="#tab-jalan" role="tab">
                    Jalan <span class="badge bg-secondary">{{ $data->total() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'kelurahan' ? 'active' : '' }}" type="button"
                        data-bs-toggle="tab" data-bs-target="#tab-kelurahan" role="tab">
                    Kelurahan <span class="badge bg-secondary">{{ $kelurahanTrashed->total() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'kecamatan' ? 'active' : '' }}" type="button"
                        data-bs-toggle="tab" data-bs-target="#tab-kecamatan" role="tab">
                    Kecamatan <span class="badge bg-secondary">{{ $kecamatanTrashed->total() }}</span>
                </button>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">

            <div class="tab-pane fade {{ $activeTab === 'jalan' ? 'show active' : '' }}" id="tab-jalan" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Jalan</th>
                                <th>Kelurahan</th>
                                <th>Kecamatan</th>
                                <th>Kondisi</th>
                                <th>Dihapus Pada</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $data->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->nama_jalan }}</td>
                                    <td>{{ $item->kelurahan->nama_kelurahan ?? '-' }}</td>
                                    <td>{{ $item->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
                                    <td>
                                        @if($item->kondisi == 'Baik')
                                            <span class="badge bg-success">Baik</span>
                                        @elseif($item->kondisi == 'Rusak Ringan')
                                            <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                        @else
                                            <span class="badge bg-danger">Rusak Berat</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('trash.restore', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">Pulihkan</button>
                                        </form>
                                        <form action="{{ route('trash.force-delete', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('PERHATIAN: Data akan dihapus permanen beserta dokumentasi foto dan riwayat kondisi. Tindakan ini tidak dapat dibatalkan. Lanjutkan?')">
                                                Hapus Permanen
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data jalan di tempat sampah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <div class="tab-pane fade {{ $activeTab === 'kelurahan' ? 'show active' : '' }}" id="tab-kelurahan" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kelurahan</th>
                                <th>Kecamatan</th>
                                <th>Dihapus Pada</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kelurahanTrashed as $item)
                                <tr>
                                    <td>{{ $kelurahanTrashed->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->nama_kelurahan }}</td>
                                    <td>
                                        {{ $item->kecamatan->nama_kecamatan ?? '-' }}
                                        @if($item->kecamatan && $item->kecamatan->trashed())
                                            <span class="badge bg-warning text-dark">Kecamatan ikut terhapus</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('trash.kelurahan.restore', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">Pulihkan</button>
                                        </form>
                                        <form action="{{ route('trash.kelurahan.force-delete', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('PERHATIAN: Data kelurahan akan dihapus permanen. Tindakan ini tidak dapat dibatalkan. Lanjutkan?')">
                                                Hapus Permanen
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data kelurahan di tempat sampah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $kelurahanTrashed->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <div class="tab-pane fade {{ $activeTab === 'kecamatan' ? 'show active' : '' }}" id="tab-kecamatan" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kecamatan</th>
                                <th>Dihapus Pada</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kecamatanTrashed as $item)
                                <tr>
                                    <td>{{ $kecamatanTrashed->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->nama_kecamatan }}</td>
                                    <td>{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('trash.kecamatan.restore', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">Pulihkan</button>
                                        </form>
                                        <form action="{{ route('trash.kecamatan.force-delete', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('PERHATIAN: Data kecamatan akan dihapus permanen. Tindakan ini tidak dapat dibatalkan. Lanjutkan?')">
                                                Hapus Permanen
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data kecamatan di tempat sampah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $kecamatanTrashed->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
