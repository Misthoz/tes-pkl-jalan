<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Jalan Lingkungan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        h2 { text-align: center; margin-bottom: 5px; }
        p.subtitle { text-align: center; color: #666; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 5px 8px; text-align: left; }
        th { background-color: #0d6efd; color: white; font-size: 10px; }
        td { font-size: 10px; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <h2>Laporan Data Jalan Lingkungan</h2>
    <p class="subtitle">Dinas Perumahan dan Kawasan Permukiman - Kota Samarinda<br>Tanggal: {{ $tanggal }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jalan</th>
                <th>Kelurahan</th>
                <th>Kecamatan</th>
                <th>Panjang (m)</th>
                <th>Lebar (m)</th>
                <th>Permukaan</th>
                <th>Kondisi</th>
                <th>Tahun</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_jalan }}</td>
                    <td>{{ $item->kelurahan->nama_kelurahan ?? '-' }}</td>
                    <td>{{ $item->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
                    <td>{{ number_format($item->panjang_meter, 0, ',', '.') }}</td>
                    <td>{{ $item->lebar_meter }}</td>
                    <td>{{ $item->jenis_permukaan }}</td>
                    <td>{{ $item->kondisi }}</td>
                    <td>{{ $item->tahun_pendataan }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total data: {{ $data->count() }} jalan | Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
