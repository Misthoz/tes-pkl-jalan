<?php

namespace Database\Seeders;

use App\Models\kelurahan;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelurahans = [
            ['kecamatan_id' => 1, 'nama_kelurahan' => 'Bugis'],
            ['kecamatan_id' => 1, 'nama_kelurahan' => 'Pelabuhan'],
            ['kecamatan_id' => 2, 'nama_kelurahan' => 'Baqa'],
            ['kecamatan_id' => 2, 'nama_kelurahan' => 'Sungai Keledang'],
            ['kecamatan_id' => 3, 'nama_kelurahan' => 'Bukuan'],
        ];

        foreach ($kelurahans as $kelurahan) {
            kelurahan::create($kelurahan);
        }
    }
}
