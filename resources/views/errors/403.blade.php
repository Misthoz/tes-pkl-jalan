@extends('layouts.app')

@section('title', '403 - Akses Ditolak')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 text-center">
        <h1 class="display-1 fw-bold text-danger">403</h1>
        <h3 class="mb-3">Akses Ditolak</h3>
        <p class="text-muted mb-4">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
