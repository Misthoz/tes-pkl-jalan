<?php

namespace App\Http\Controllers;

use App\Http\Requests\kelurahanRequest;
use App\Models\kecamatan;
use App\Models\kelurahan;
use Illuminate\Http\Request;

class kelurahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = kelurahan::with('kecamatan')->latest()->paginate(10);

        return view('kelurahan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kecamatan = kecamatan::all();

        return view('kelurahan.create', compact('kecamatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(kelurahanRequest $request)
    {
        kelurahan::create($request->validated());

        return redirect()
            ->route('kelurahan.index')
            ->with('success', 'data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelurahan = kelurahan::with('kecamatan')->findOrFail($id);
        return view('kelurahan.show', compact('kelurahan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(kelurahan $kelurahan)
    {
        $kecamatan = kecamatan::all();

        return view('kelurahan.edit', compact('kelurahan', 'kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(kelurahanRequest $request, kelurahan $kelurahan)
    {
        $kelurahan->update($request->validated());

        return redirect()
            ->route('kelurahan.index')
            ->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kelurahan $kelurahan)
    {
        if ($kelurahan->jalan()->count() > 0) {
            return redirect()
                ->route('kelurahan.index')
                ->with('error', 'data tidak bisa dihapus karena masih memiliki data jalan');
        }

        $kelurahan->delete();
        return redirect()
            ->route('kelurahan.index')
            ->with('success', 'data berhasil di hapus');
    }
}
