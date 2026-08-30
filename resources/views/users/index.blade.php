@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pengguna</h5>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Tambah Pengguna</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->name }}</td>
                            <td><code>{{ $user->username }}</code></td>
                            <td>
                                @if($user->role === 'Admin')
                                    <span class="badge bg-danger">Admin</span>
                                @else
                                    <span class="badge bg-info">Petugas</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline js-form-hapus-pengguna" data-name="{{ $user->name }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.js-form-hapus-pengguna').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const nama = form.dataset.name || 'ini';

            if (!confirm('Yakin ingin menghapus pengguna ' + nama + '?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection
