<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($data['role'] !== 'Admin' && $this->isLastAdmin($user)) {
            return back()
                ->withInput()
                ->withErrors([
                    'role' => 'Role tidak dapat diubah karena ini satu-satunya akun Admin yang tersisa. Angkat pengguna lain menjadi Admin terlebih dahulu, lalu ulangi.',
                ]);
        }

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

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

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

    private function isLastAdmin(User $user): bool
    {
        return $user->isAdmin() && User::where('role', 'Admin')->count() <= 1;
    }
}
