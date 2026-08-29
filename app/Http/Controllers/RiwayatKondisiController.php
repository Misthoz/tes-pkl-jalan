<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKondisi;
use Illuminate\Http\Request;

class RiwayatKondisiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jalan_id' => 'required|exists:jalan,id,deleted_at,NULL',
            'tanggal_survei' => 'required|date|before_or_equal:today',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'jalan_id.exists' => 'Data jalan tidak ditemukan atau sudah dipindahkan ke trash.',
            'tanggal_survei.required' => 'Tanggal survei wajib diisi.',
            'tanggal_survei.before_or_equal' => 'Tanggal survei tidak boleh di masa depan.',
            'kondisi.required' => 'Kondisi wajib dipilih.',
            'kondisi.in' => 'Kondisi hanya boleh: Baik, Rusak Ringan, atau Rusak Berat.',
        ]);

        RiwayatKondisi::create([
            'jalan_id' => $request->jalan_id,
            'tanggal_survei' => $request->tanggal_survei,
            'kondisi' => $request->kondisi,
            'keterangan' => $request->keterangan,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Riwayat kondisi berhasil ditambahkan.');
    }
}
