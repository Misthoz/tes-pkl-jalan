<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kecamatan;
use App\Http\Requests\kecamatanRequest;

class kecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kecamatan = kecamatan::latest()->paginate(10);

        return view('kecamatan.index', compact('kecamatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kecamatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(kecamatanRequest $request)
    {
        kecamatan::create($request->validated());

        return redirect()
            ->route('kecamatan.index')
            ->with('success', 'data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kecamatan = kecamatan::findOrFail($id);
        return view('kecamatan.show', compact('kecamatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(kecamatan $kecamatan)
    {
        return view('kecamatan.edit', compact('kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(kecamatanRequest $request, kecamatan $kecamatan)
    {
        $kecamatan->update($request->validated());

        return redirect()
            ->route('kecamatan.index')
            ->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kecamatan $kecamatan)
    {
        if ($kecamatan->kelurahan()->withTrashed()->count() > 0) {
            return redirect()
                ->route('kecamatan.index')
                ->with('error', 'data tidak bisa dihapus karena masih memiliki data kelurahan (termasuk yang ada di trash)');
        }

        $kecamatan->delete();
        return redirect()
            ->route('kecamatan.index')
            ->with('success', 'data berhasil di hapus');
    }
}
