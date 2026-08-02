@extends('layouts.app')

@section('title', 'Detail Jalan')

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
        
        <div class="mt-4">
            <a href="{{ route('jalan.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('jalan.edit', $jalan->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection
