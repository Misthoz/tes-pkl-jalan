<?php

namespace App\Http\Controllers;

use App\Models\DokumentasiJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jalan_id' => 'required|exists:jalan,id,deleted_at,NULL',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tanggal_dokumentasi' => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'jalan_id.exists' => 'Data jalan tidak ditemukan atau sudah dipindahkan ke trash.',
            'foto.required' => 'Foto wajib diupload.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPEG, PNG, JPG, atau WebP.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
            'tanggal_dokumentasi.required' => 'Tanggal dokumentasi wajib diisi.',
        ]);

        $path = $request->file('foto')->store('dokumentasi', 'public');

        if ($path === false) {
            return redirect()
                ->back()
                ->with('error', 'Foto gagal disimpan ke server. Penyimpanan mungkin penuh atau tidak dapat ditulis. Silakan coba lagi atau hubungi administrator.');
        }

        DokumentasiJalan::create([
            'jalan_id' => $request->jalan_id,
            'foto' => $path,
            'tanggal_dokumentasi' => $request->tanggal_dokumentasi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Foto dokumentasi berhasil ditambahkan.');
    }

    public function destroy(DokumentasiJalan $dokumentasi)
    {
        if (Storage::disk('public')->exists($dokumentasi->foto)) {
            Storage::disk('public')->delete($dokumentasi->foto);
        }

        $dokumentasi->delete();

        return redirect()
            ->back()
            ->with('success', 'Foto dokumentasi berhasil dihapus.');
    }
}
