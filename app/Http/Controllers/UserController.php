<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Tampilkan form tambah pengguna.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Simpan pengguna baru.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail pengguna.
     */
    public function show(User $user)
    {
        // Route model binding (User $user), bukan string $id + findOrFail seperti
        // show() di jalan/kelurahan/kecamatanController. Hasilnya sama -- binding
        // memanggil findOrFail() secara internal, jadi ID yang tidak ada tetap
        // menghasilkan 404 -- tapi bentuk ini konsisten dengan edit(), update(),
        // dan destroy() di file INI, yang semuanya sudah memakai binding.
        //
        // Tidak ada eager loading: tabel users tidak punya relasi yang dibaca
        // view ini. Kolom user_id di riwayat_kondisi menunjuk ke sini, tapi
        // model User belum punya relasi hasMany ke arah itu dan halaman ini
        // tidak menampilkan daftar survei.
        return view('users.show', compact('user'));
    }

    /**
     * Tampilkan form edit pengguna.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update data pengguna.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        // Guard "Admin terakhir": operasi ini tidak boleh menyisakan nol Admin.
        // /users dan /trash dilindungi middleware role:Admin, jadi begitu tidak
        // ada Admin yang tersisa, tidak ada lagi jalur lewat UI untuk mengangkat
        // Admin baru -- instalasi terkunci permanen dari user management dan
        // hanya bisa dipulihkan lewat query manual ke database. Instalasi
        // default hanya punya SATU Admin (lihat UserSeeder), jadi kondisi ini
        // sangat mudah tercapai.
        //
        // Kondisinya sengaja dirumuskan sebagai "apakah masih ada Admin setelah
        // update ini", bukan "apakah user sedang menurunkan dirinya sendiri".
        // Bentuk ini otomatis mencakup kasus self-demotion dan tetap benar kalau
        // nanti ada jalur lain yang bisa mengubah role.
        if ($data['role'] !== 'Admin' && $this->isLastAdmin($user)) {
            return back()
                ->withInput()
                ->withErrors([
                    'role' => 'Role tidak dapat diubah karena ini satu-satunya akun Admin yang tersisa. Angkat pengguna lain menjadi Admin terlebih dahulu, lalu ulangi.',
                ]);
        }

        // Jika password kosong, pertahankan password lama
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Hapus pengguna.
     */
    public function destroy(User $user)
    {
        // Proteksi: Admin tidak bisa menghapus akun sendiri
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        // Guard "Admin terakhir", aturan yang sama seperti di update() supaya
        // kedua jalur konsisten.
        //
        // Dengan RoleMiddleware yang ada sekarang kondisi ini tidak bisa
        // tercapai: yang menghapus pasti Admin (route dibungkus role:Admin) dan
        // self-delete sudah diblokir di atas, jadi minimal selalu ada satu Admin
        // yang tersisa. Guard ini dipasang supaya invariannya eksplisit dan
        // tidak bergantung pada penalaran itu -- kalau nanti ada Gate/Policy,
        // perintah artisan, atau endpoint lain yang bisa menghapus pengguna,
        // proteksinya tidak ikut hilang.
        if ($this->isLastAdmin($user)) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Pengguna "' . $user->name . '" tidak dapat dihapus karena merupakan satu-satunya akun Admin yang tersisa. Angkat pengguna lain menjadi Admin terlebih dahulu.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Apakah $user merupakan satu-satunya Admin yang tersisa?
     *
     * Dipakai bersama oleh update() dan destroy() supaya invarian "selalu ada
     * minimal satu Admin" ditegakkan dengan aturan yang sama di kedua jalur.
     *
     * Tabel users tidak memakai SoftDeletes, jadi count() di sini sudah
     * mencerminkan Admin yang benar-benar masih bisa login -- tidak ada baris
     * ter-trash yang perlu dikecualikan.
     */
    private function isLastAdmin(User $user): bool
    {
        return $user->isAdmin() && User::where('role', 'Admin')->count() <= 1;
    }
}
