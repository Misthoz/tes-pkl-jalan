<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pendataan Jalan')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Pendataan Jalan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kecamatan*') ? 'active' : '' }}" href="{{ route('kecamatan.index') }}">Kecamatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kelurahan*') ? 'active' : '' }}" href="{{ route('kelurahan.index') }}">Kelurahan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('jalan*') ? 'active' : '' }}" href="{{ route('jalan.index') }}">Jalanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('peta*') ? 'active' : '' }}" href="{{ route('peta.index') }}">Peta Jalan</a>
                </li>
                @if(auth()->user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('trash*') ? 'active' : '' }}" href="{{ route('trash.index') }}">Tempat Sampah</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">User</a>
                </li>
                @endif
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ auth()->user()->name }}
                        <span class="badge {{ auth()->user()->isAdmin() ? 'bg-danger' : 'bg-info' }}">{{ auth()->user()->role }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container pb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Jaring pengaman untuk error validasi. Tanpa ini, halaman yang lupa
         memasang @error di form-nya akan menerima redirect back tanpa pesan
         apa pun -- terlihat sama seperti berhasil.

         Sengaja hanya membaca bag 'default': halaman yang memakai named error
         bag (lihat jalan/show.blade.php) sudah menampilkan pesannya sendiri di
         dalam form masing-masing, jadi menampilkan semua bag di sini hanya
         menghasilkan pesan ganda. --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan pada input Anda.</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $pesan)
                    <li>{{ $pesan }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
