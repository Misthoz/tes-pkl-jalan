<?php

namespace App\Http\Controllers;

use App\Models\jalan;
use App\Models\kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = jalan::query();

        if ($request->filled('kecamatan_id')) {
            $query->whereHas('kelurahan', function ($q) use ($request) {
                $q->where('kecamatan_id', $request->kecamatan_id);
            });
        }

        if ($request->filled('kelurahan_id')) {
            $query->where('kelurahan_id', $request->kelurahan_id);
        }

        $stats = [
            'total_jalan' => (clone $query)->count(),
            'total_panjang' => (clone $query)->sum('panjang_meter'),
            'kondisi_baik' => (clone $query)->where('kondisi', 'Baik')->count(),
            'kondisi_rusak_ringan' => (clone $query)->where('kondisi', 'Rusak Ringan')->count(),
            'kondisi_rusak_berat' => (clone $query)->where('kondisi', 'Rusak Berat')->count(),
        ];

        $grafikKondisi = [
            ['label' => 'Baik', 'value' => $stats['kondisi_baik'], 'color' => '#198754'],
            ['label' => 'Rusak Ringan', 'value' => $stats['kondisi_rusak_ringan'], 'color' => '#ffc107'],
            ['label' => 'Rusak Berat', 'value' => $stats['kondisi_rusak_berat'], 'color' => '#dc3545'],
        ];

        $grafikPermukaan = (clone $query)->select('jenis_permukaan', DB::raw('count(*) as total'))
            ->groupBy('jenis_permukaan')
            ->pluck('total', 'jenis_permukaan')
            ->toArray();

        $kecamatanRusakTerbanyak = (clone $query)
            ->join('kelurahan', 'jalan.kelurahan_id', '=', 'kelurahan.id')
            ->join('kecamatan', 'kelurahan.kecamatan_id', '=', 'kecamatan.id')
            ->whereNull('kelurahan.deleted_at')
            ->whereNull('kecamatan.deleted_at')
            ->whereIn('jalan.kondisi', ['Rusak Ringan', 'Rusak Berat'])
            ->select('kecamatan.nama_kecamatan', DB::raw('count(*) as jalan_rusak_count'))
            ->groupBy('kecamatan.id', 'kecamatan.nama_kecamatan')
            ->orderByDesc('jalan_rusak_count')
            ->limit(5)
            ->get();

        $kecamatan = kecamatan::with('kelurahan')->orderBy('nama_kecamatan')->get();

        return view('dashboard.index', compact(
            'stats', 'grafikKondisi', 'grafikPermukaan',
            'kecamatanRusakTerbanyak', 'kecamatan'
        ));
    }
}
