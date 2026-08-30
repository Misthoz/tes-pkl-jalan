<?php

namespace App\Http\Controllers;

use App\Models\jalan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\JalanExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    private function buildQuery(Request $request)
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

        return $query;
    }

    public function exportPdf(Request $request)
    {
        $data = $this->buildQuery($request)->get();
        $tanggal = now()->format('d-m-Y');

        $pdf = Pdf::loadView('exports.jalan_pdf', compact('data', 'tanggal'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-jalan-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new JalanExport($this->buildQuery($request)),
            'laporan-jalan-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
