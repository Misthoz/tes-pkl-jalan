@extends('layouts.app')

@section('title', 'Beranda - Sistem Pendataan Jalan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 text-center mt-5">
        <h1 class="display-4 fw-bold">Sistem Pendataan Jalan Lingkungan</h1>
        <p class="lead mt-3">Aplikasi sederhana untuk mencatat jalan berdasarkan kelurahan dan kecamatan.</p>
        
        <div class="row mt-5">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Kecamatan</h5>
                        <p class="card-text text-muted">Kelola data kecamatan di wilayah kota.</p>
                        <a href="{{ route('kecamatan.index') }}" class="btn btn-primary">Lihat Kecamatan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Kelurahan</h5>
                        <p class="card-text text-muted">Kelola data kelurahan yang terhubung ke kecamatan.</p>
                        <a href="{{ route('kelurahan.index') }}" class="btn btn-primary">Lihat Kelurahan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Jalan Lingkungan</h5>
                        <p class="card-text text-muted">Data jalan, panjang, lebar, jenis permukaan, dan kondisi.</p>
                        <a href="{{ route('jalan.index') }}" class="btn btn-primary">Lihat Jalan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
