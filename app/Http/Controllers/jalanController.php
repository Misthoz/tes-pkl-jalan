<?php

namespace App\Http\Controllers;

use App\Http\Requests\jalanRequest;
use App\Models\jalan;
use App\Models\kecamatan;
use App\Models\kelurahan;
use Illuminate\Http\Request;

class jalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = jalan::with('kelurahan.kecamatan');

        if ($request->filled('search')) {
            $query->where('nama_jalan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kondisi') && $request->kondisi != 'Semua') {
            if (in_array($request->kondisi, ['Baik', 'Rusak Ringan', 'Rusak Berat'])) {
                $query->where('kondisi', $request->kondisi);
            }
        }

        if ($request->filled('jenis_permukaan') && $request->jenis_permukaan != 'Semua') {
            if (in_array($request->jenis_permukaan, ['Aspal', 'Beton', 'Paving', 'Tanah'])) {
                $query->where('jenis_permukaan', $request->jenis_permukaan);
            }
        }

        if ($request->filled('kecamatan_id')) {
            $query->whereHas('kelurahan', function ($q) use ($request) {
                $q->where('kecamatan_id', $request->kecamatan_id);
            });
        }

        if ($request->filled('kelurahan_id')) {
            $query->where('kelurahan_id', $request->kelurahan_id);
        }

        if ($request->filled('tahun_pendataan')) {
            $tahun = (int) $request->tahun_pendataan;
            if ($tahun >= 2000 && $tahun <= date('Y')) {
                $query->where('tahun_pendataan', $tahun);
            }
        }

        if ($request->filled('panjang_min')) {
            $query->where('panjang_meter', '>=', (int) $request->panjang_min);
        }
        if ($request->filled('panjang_max')) {
            $query->where('panjang_meter', '<=', (int) $request->panjang_max);
        }

        $summary = [
            'total_jalan' => (clone $query)->count(),
            'kondisi_baik' => (clone $query)->where('kondisi', 'Baik')->count(),
            'kondisi_rusak_ringan' => (clone $query)->where('kondisi', 'Rusak Ringan')->count(),
            'kondisi_rusak_berat' => (clone $query)->where('kondisi', 'Rusak Berat')->count(),
            'total_panjang' => (clone $query)->sum('panjang_meter'),
        ];

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        $allowedSorts = ['nama_jalan', 'panjang_meter', 'kondisi', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'desc';
        }

        $query->orderBy($sortBy, $sortDir);

        $data = $query->paginate(10)->withQueryString();

        $kecamatanList = kecamatan::with('kelurahan')->orderBy('nama_kecamatan')->get();
        $tahunList = jalan::select('tahun_pendataan')->distinct()->orderBy('tahun_pendataan', 'desc')->pluck('tahun_pendataan');

        return view('jalan.index', compact('data', 'summary', 'kecamatanList', 'tahunList'));
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
        $jalan = jalan::with(['kelurahan.kecamatan', 'dokumentasi', 'riwayatKondisi.user'])->findOrFail($id);
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
