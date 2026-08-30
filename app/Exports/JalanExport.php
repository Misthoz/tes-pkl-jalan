<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JalanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $query;
    protected $rowNumber = 0;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection(): Collection
    {
        return $this->query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Jalan',
            'Kelurahan',
            'Kecamatan',
            'Panjang (m)',
            'Lebar (m)',
            'Jenis Permukaan',
            'Kondisi',
            'Tahun Pendataan',
            'Keterangan',
        ];
    }

    public function map($jalan): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $jalan->nama_jalan,
            $jalan->kelurahan->nama_kelurahan ?? '-',
            $jalan->kelurahan->kecamatan->nama_kecamatan ?? '-',
            $jalan->panjang_meter,
            $jalan->lebar_meter,
            $jalan->jenis_permukaan,
            $jalan->kondisi,
            $jalan->tahun_pendataan,
            $jalan->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
