@extends('layouts.app')

@section('title', 'Data Kecamatan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Kecamatan</h5>
        <a href="{{ route('kecamatan.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Kecamatan</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kecamatan as $data)
                        <tr>
                            <td>{{ $kecamatan->firstItem() + $loop->index }}</td>
                            <td>{{ $data->nama_kecamatan }}</td>
                            <td>
                                <a href="{{ route('kecamatan.show', $data->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('kecamatan.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('kecamatan.destroy', $data->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $kecamatan->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection