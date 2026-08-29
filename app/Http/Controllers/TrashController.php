<?php

namespace App\Http\Controllers;

use App\Models\jalan;
use App\Models\kecamatan;
use App\Models\kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrashController extends Controller
{
    public function index()
    {
        $data = jalan::onlyTrashed()
            ->with('kelurahan.kecamatan')
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'page_jalan');

        $kelurahanTrashed = kelurahan::onlyTrashed()
            ->with(['kecamatan' => function ($query) {
                $query->withTrashed();
            }])
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'page_kelurahan');

        $kecamatanTrashed = kecamatan::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'page_kecamatan');

        return view('trash.index', compact('data', 'kelurahanTrashed', 'kecamatanTrashed'));
    }

    public function restore(string $id)
    {
        $jalan = jalan::onlyTrashed()->findOrFail($id);

        if (jalan::where('nama_jalan', $jalan->nama_jalan)->exists()) {
            return redirect()
                ->route('trash.index')
                ->with('error', 'Data jalan "' . $jalan->nama_jalan . '" tidak bisa dipulihkan karena sudah ada jalan aktif dengan nama yang sama. Ubah nama jalan yang aktif, atau hapus permanen salah satunya.');
        }

        if (! kelurahan::whereKey($jalan->kelurahan_id)->exists()) {
            return redirect()
                ->route('trash.index')
                ->with('error', 'Data jalan "' . $jalan->nama_jalan . '" tidak bisa dipulihkan karena kelurahan induknya masih terhapus. Pulihkan kelurahan induknya terlebih dahulu.');
        }

        $jalan->restore();

        return redirect()
            ->route('trash.index')
            ->with('success', 'Data jalan "' . $jalan->nama_jalan . '" berhasil dipulihkan.');
    }

    public function forceDelete(string $id)
    {
        $jalan = jalan::onlyTrashed()->with('dokumentasi')->findOrFail($id);

        foreach ($jalan->dokumentasi as $dok) {
            if (Storage::disk('public')->exists($dok->foto)) {
                Storage::disk('public')->delete($dok->foto);
            }
        }

        $jalan->forceDelete();

        return redirect()
            ->route('trash.index')
            ->with('success', 'Data jalan berhasil dihapus permanen.');
    }

    public function restoreKelurahan(string $id)
    {
        $kelurahan = kelurahan::onlyTrashed()->findOrFail($id);

        if (kelurahan::where('nama_kelurahan', $kelurahan->nama_kelurahan)->exists()) {
            return redirect()
                ->route('trash.index')
                ->with('error', 'Kelurahan "' . $kelurahan->nama_kelurahan . '" tidak bisa dipulihkan karena sudah ada kelurahan aktif dengan nama yang sama. Ubah nama kelurahan yang aktif, atau hapus permanen salah satunya.');
        }

        if (! kecamatan::whereKey($kelurahan->kecamatan_id)->exists()) {
            return redirect()
                ->route('trash.index')
                ->with('error', 'Kelurahan "' . $kelurahan->nama_kelurahan . '" tidak bisa dipulihkan karena kecamatan induknya masih terhapus. Pulihkan kecamatan induknya terlebih dahulu.');
        }

        $kelurahan->restore();

        return redirect()
            ->route('trash.index')
            ->with('success', 'Data kelurahan "' . $kelurahan->nama_kelurahan . '" berhasil dipulihkan.');
    }

    public function forceDeleteKelurahan(string $id)
    {
        $kelurahan = kelurahan::onlyTrashed()->findOrFail($id);

        if ($kelurahan->jalan()->withTrashed()->count() > 0) {
            return redirect()
                ->route('trash.index')
                ->with('error', 'Kelurahan "' . $kelurahan->nama_kelurahan . '" tidak bisa dihapus permanen karena masih memiliki data jalan (termasuk yang ada di trash). Hapus permanen data jalan tersebut terlebih dahulu.');
        }

        $nama = $kelurahan->nama_kelurahan;
        $kelurahan->forceDelete();

        return redirect()
            ->route('trash.index')
            ->with('success', 'Data kelurahan "' . $nama . '" berhasil dihapus permanen.');
    }

    public function restoreKecamatan(string $id)
    {
        $kecamatan = kecamatan::onlyTrashed()->findOrFail($id);

        if (kecamatan::where('nama_kecamatan', $kecamatan->nama_kecamatan)->exists()) {
            return redirect()
                ->route('trash.index')
                ->with('error', 'Kecamatan "' . $kecamatan->nama_kecamatan . '" tidak bisa dipulihkan karena sudah ada kecamatan aktif dengan nama yang sama. Ubah nama kecamatan yang aktif, atau hapus permanen salah satunya.');
        }

        $kecamatan->restore();

        return redirect()
            ->route('trash.index')
            ->with('success', 'Data kecamatan "' . $kecamatan->nama_kecamatan . '" berhasil dipulihkan.');
    }

    public function forceDeleteKecamatan(string $id)
    {
        $kecamatan = kecamatan::onlyTrashed()->findOrFail($id);

        if ($kecamatan->kelurahan()->withTrashed()->count() > 0) {
            return redirect()
                ->route('trash.index')
                ->with('error', 'Kecamatan "' . $kecamatan->nama_kecamatan . '" tidak bisa dihapus permanen karena masih memiliki data kelurahan (termasuk yang ada di trash). Hapus permanen data kelurahan tersebut terlebih dahulu.');
        }

        $nama = $kecamatan->nama_kecamatan;
        $kecamatan->forceDelete();

        return redirect()
            ->route('trash.index')
            ->with('success', 'Data kecamatan "' . $nama . '" berhasil dihapus permanen.');
    }
}
