<?php

namespace Database\Seeders;

use App\Models\jalan;
use Illuminate\Database\Seeder;

class JalanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jalans = [
            [
                'kelurahan_id' => 1,
                'nama_jalan' => 'Jl. Awang Long',
                'panjang_meter' => 800,
                'lebar_meter' => 6.5,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2023,
                'keterangan' => 'Jalan utama'
            ],
            [
                'kelurahan_id' => 1,
                'nama_jalan' => 'Jl. Jendral Sudirman',
                'panjang_meter' => 1200,
                'lebar_meter' => 8.0,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2023,
                'keterangan' => 'Depan kantor gubernur lama'
            ],
            [
                'kelurahan_id' => 2,
                'nama_jalan' => 'Jl. Yos Sudarso',
                'panjang_meter' => 1500,
                'lebar_meter' => 7.0,
                'jenis_permukaan' => 'Beton',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2022,
                'keterangan' => 'Akses pelabuhan'
            ],
            [
                'kelurahan_id' => 2,
                'nama_jalan' => 'Jl. Niaga Utara',
                'panjang_meter' => 450,
                'lebar_meter' => 5.0,
                'jenis_permukaan' => 'Paving',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2024,
                'keterangan' => 'Kawasan niaga'
            ],
            [
                'kelurahan_id' => 3,
                'nama_jalan' => 'Jl. Hasanuddin',
                'panjang_meter' => 2000,
                'lebar_meter' => 6.0,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2023,
                'keterangan' => ''
            ],
            [
                'kelurahan_id' => 4,
                'nama_jalan' => 'Jl. Bung Tomo',
                'panjang_meter' => 3500,
                'lebar_meter' => 7.5,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2023,
                'keterangan' => 'Jalan poros seberang'
            ],
            [
                'kelurahan_id' => 5,
                'nama_jalan' => 'Jl. Pangeran Diponegoro',
                'panjang_meter' => 1800,
                'lebar_meter' => 5.5,
                'jenis_permukaan' => 'Beton',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2024,
                'keterangan' => 'Akses perumahan'
            ],
            [
                'kelurahan_id' => 5,
                'nama_jalan' => 'Jl. Karya Bhakti',
                'panjang_meter' => 900,
                'lebar_meter' => 4.0,
                'jenis_permukaan' => 'Tanah',
                'kondisi' => 'Rusak Berat',
                'tahun_pendataan' => 2021,
                'keterangan' => 'Masih berupa jalan tanah'
            ],
        ];

        foreach ($jalans as $jalan) {
            jalan::create($jalan);
        }
    }
}
