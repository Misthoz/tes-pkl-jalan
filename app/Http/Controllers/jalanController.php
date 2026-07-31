<?php

namespace App\Http\Controllers;

use App\Http\Requests\jalanRequest;
use App\Models\jalan;
use App\Models\kelurahan;
use Illuminate\Http\Request;

class jalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = jalan::with('kelurahan.kecamatan')->latest();

        if ($request->filled('search')) {
            $query->where('nama_jalan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kondisi') && $request->kondisi != 'Semua') {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('jenis_permukaan') && $request->jenis_permukaan != 'Semua') {
            $query->where('jenis_permukaan', $request->jenis_permukaan);
        }

        $data = $query->paginate(10)->withQueryString();

        $summary = [
            'total_jalan' => jalan::count(),
            'kondisi_baik' => jalan::where('kondisi', 'Baik')->count(),
            'kondisi_rusak_ringan' => jalan::where('kondisi', 'Rusak Ringan')->count(),
            'kondisi_rusak_berat' => jalan::where('kondisi', 'Rusak Berat')->count(),
            'total_panjang' => jalan::sum('panjang_meter')
        ];

        return view('jalan.index', compact('data', 'summary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelurahan = kelurahan::with('kecamatan')->get();

        return view('jalan.create', compact('kelurahan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(jalanRequest $request)
    {
        jalan::create($request->validated());

        return redirect()
            ->route('jalan.index')
            ->with('success', 'data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jalan = jalan::with('kelurahan.kecamatan')->findOrFail($id);
        return view('jalan.show', compact('jalan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(jalan $jalan)
    {
        $kelurahan = kelurahan::with('kecamatan')->get();

        return view('jalan.edit', compact('jalan', 'kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(jalanRequest $request, jalan $jalan)
    {
        $jalan->update($request->validated());

        return redirect()
            ->route('jalan.index')
            ->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jalan $jalan)
    {
        $jalan->delete();

        return redirect()
            ->route('jalan.index')
            ->with('success', 'data berhasil di hapus');
    }
}
