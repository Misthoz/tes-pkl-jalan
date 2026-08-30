<?php

namespace Database\Seeders;

use App\Models\kecamatan;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatans = [
            ['nama_kecamatan' => 'Samarinda Kota'],
            ['nama_kecamatan' => 'Samarinda Ulu'],
            ['nama_kecamatan' => 'Samarinda Ilir'],
            ['nama_kecamatan' => 'Samarinda Utara'],
            ['nama_kecamatan' => 'Samarinda Seberang'],
            ['nama_kecamatan' => 'Sungai Kunjang'],
            ['nama_kecamatan' => 'Sungai Pinang'],
            ['nama_kecamatan' => 'Sambutan'],
            ['nama_kecamatan' => 'Loa Janan Ilir'],
            ['nama_kecamatan' => 'Palaran'],
        ];

        foreach ($kecamatans as $kecamatan) {
            kecamatan::create($kecamatan);
        }
    }
}
