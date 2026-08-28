<?php

namespace App\Http\Controllers;

use App\Models\jalan;
use App\Models\kecamatan;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index(Request $request)
    {
        $query = jalan::with('kelurahan.kecamatan')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        if ($request->filled('kecamatan_id')) {
            $query->whereHas('kelurahan', function ($q) use ($request) {
                $q->where('kecamatan_id', $request->kecamatan_id);
            });
        }

        if ($request->filled('kelurahan_id')) {
            $query->where('kelurahan_id', $request->kelurahan_id);
        }

        if ($request->filled('kondisi') && $request->kondisi != 'Semua') {
            $query->where('kondisi', $request->kondisi);
        }

        $jalanData = $query->get();
        $kecamatan = kecamatan::with('kelurahan')->orderBy('nama_kecamatan')->get();

        return view('peta.index', compact('jalanData', 'kecamatan'));
    }
}
