<?php

namespace Database\Seeders;

use App\Models\kecamatan;
use App\Models\kelurahan;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelurahanPerKecamatan = [
            'Samarinda Kota' => [
                'Bugis',
                'Karang Mumus',
                'Pasar Pagi',
                'Pelabuhan',
                'Sungai Pinang Luar',
            ],
            'Samarinda Ulu' => [
                'Air Hitam',
                'Air Putih',
                'Bukit Pinang',
                'Dadi Mulya',
                'Gunung Kelua',
                'Jawa',
                'Sidodadi',
                'Teluk Lerong Ilir',
            ],
            'Samarinda Ilir' => [
                'Pelita',
                'Selili',
                'Sidodamai',
                'Sidomulyo',
                'Sungai Dama',
            ],
            'Samarinda Utara' => [
                'Budaya Pampang',
                'Lempake',
                'Sempaja Barat',
                'Sempaja Selatan',
                'Sempaja Timur',
                'Sempaja Utara',
                'Sungai Siring',
                'Tanah Merah',
            ],
            'Samarinda Seberang' => [
                'Baqa',
                'Gunung Panjang',
                'Mangkupalas',
                'Mesjid',
                'Sungai Keledang',
                'Tenun',
            ],
            'Sungai Kunjang' => [
                'Karang Anyar',
                'Karang Asam Ilir',
                'Karang Asam Ulu',
                'Loa Bakung',
                'Loa Buah',
                'Lok Bahu',
                'Teluk Lerong Ulu',
            ],
            'Sungai Pinang' => [
                'Bandara',
                'Gunung Lingai',
                'Mugirejo',
                'Sungai Pinang Dalam',
                'Temindung Permai',
            ],
            'Sambutan' => [
                'Makroman',
                'Pulau Atas',
                'Sambutan',
                'Sindang Sari',
                'Sungai Kapih',
            ],
            'Loa Janan Ilir' => [
                'Harapan Baru',
                'Rapak Dalam',
                'Sengkotek',
                'Simpang Tiga',
                'Tani Aman',
            ],
            'Palaran' => [
                'Bantuas',
                'Bukuan',
                'Handil Bakti',
                'Rawa Makmur',
                'Simpang Pasir',
            ],
        ];

        $petaKecamatan = kecamatan::pluck('id', 'nama_kecamatan');

        foreach ($kelurahanPerKecamatan as $namaKecamatan => $daftarKelurahan) {
            if (! isset($petaKecamatan[$namaKecamatan])) {
                throw new \RuntimeException(
                    "Kecamatan \"{$namaKecamatan}\" tidak ditemukan. Pastikan KecamatanSeeder dijalankan lebih dulu (lihat urutan di DatabaseSeeder)."
                );
            }

            foreach ($daftarKelurahan as $namaKelurahan) {
                kelurahan::create([
                    'kecamatan_id' => $petaKecamatan[$namaKecamatan],
                    'nama_kelurahan' => $namaKelurahan,
                ]);
            }
        }
    }
}
