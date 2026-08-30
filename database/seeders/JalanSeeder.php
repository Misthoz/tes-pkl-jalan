<?php

namespace Database\Seeders;

use App\Models\jalan;
use App\Models\kelurahan;
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
                'kelurahan' => 'Pasar Pagi',
                'nama_jalan' => 'Jl. Jenderal Sudirman',
                'panjang_meter' => 1200,
                'lebar_meter' => 8.00,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2025,
                'keterangan' => 'Jalan arteri pusat kota, kawasan perkantoran dan pertokoan.',
                'latitude' => -0.5008743446818785,
                'longitude' =>  117.14303419735562,
            ],
            [
                'kelurahan' => 'Bugis',
                'nama_jalan' => 'Jl. Awang Long',
                'panjang_meter' => 800,
                'lebar_meter' => 6.50,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2024,
                'keterangan' => 'Jalan kolektor di pusat kota.',
                'latitude' => -0.4997541172345853,
                'longitude' =>  117.14396376666573,
            ],
            [
                'kelurahan' => 'Pasar Pagi',
                'nama_jalan' => 'Jl. Niaga Utara',
                'panjang_meter' => 450,
                'lebar_meter' => 5.00,
                'jenis_permukaan' => 'Paving',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2023,
                'keterangan' => 'Kawasan niaga Pasar Pagi, paving mulai bergelombang.',
                'latitude' => -0.5034865310626346, 
                'longitude' => 117.1512675378295
            ],
            [
                'kelurahan' => 'Pelabuhan',
                'nama_jalan' => 'Jl. Yos Sudarso',
                'panjang_meter' => 1500,
                'lebar_meter' => 7.00,
                'jenis_permukaan' => 'Beton',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2024,
                'keterangan' => 'Akses pelabuhan, sering dilewati kendaraan berat.',
                'latitude' => -0.5054973163808552, 
                'longitude' => 117.15266548201076
            ],
            [
                'kelurahan' => 'Air Putih',
                'nama_jalan' => 'Jl. Ir. H. Juanda',
                'panjang_meter' => 2600,
                'lebar_meter' => 9.00,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2025,
                'keterangan' => 'Jalan arteri, salah satu jalur utama menuju pusat kota.',
                'latitude' => -0.4809701734458007, 
                'longitude' => 117.13450303968321
            ],
            [
                'kelurahan' => 'Teluk Lerong Ilir',
                'nama_jalan' => 'Jl. Pangeran Antasari',
                'panjang_meter' => 1900,
                'lebar_meter' => 8.00,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2024,
                'keterangan' => 'Terdapat beberapa lubang di sisi utara.',
                'latitude' => -0.492327272908052, 
                'longitude' => 117.1271476648121
            ],
            [
                'kelurahan' => 'Air Hitam',
                'nama_jalan' => 'Jl. Kadrie Oening',
                'panjang_meter' => 3200,
                'lebar_meter' => 9.00,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2026,
                'keterangan' => 'Jalan arteri, kawasan perdagangan dan jasa.',
                'latitude' => -0.47172225785793526, 
                'longitude' => 117.1307553531745
            ],
            [
                'kelurahan' => 'Gunung Kelua',
                'nama_jalan' => 'Jl. Pramuka',
                'panjang_meter' => 1400,
                'lebar_meter' => 6.00,
                'jenis_permukaan' => 'Beton',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2025,
                'keterangan' => 'Kawasan kampus, padat pada jam masuk dan pulang kuliah.',
                'latitude' => -0.46360630135784203, 
                'longitude' => 117.15326681084707
            ],
            [
                'kelurahan' => 'Sidodamai',
                'nama_jalan' => 'Jl. Otto Iskandardinata',
                'panjang_meter' => 1100,
                'lebar_meter' => 6.00,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2024,
                'keterangan' => '',
                'latitude' => -0.5045362037404084, 
                'longitude' => 117.16241993782954
            ],
            [
                'kelurahan' => 'Selili',
                'nama_jalan' => 'Jl. Lambung Mangkurat',
                'panjang_meter' => 950,
                'lebar_meter' => 5.50,
                'jenis_permukaan' => 'Beton',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2023,
                'keterangan' => 'Beberapa segmen beton retak.',
                'latitude' => -0.48909213061013196, 
                'longitude' => 117.16004088015697
            ],
            [
                'kelurahan' => 'Pelita',
                'nama_jalan' => 'Jl. Kesuma Bangsa',
                'panjang_meter' => 1300,
                'lebar_meter' => 7.00,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2025,
                'keterangan' => 'Dekat kawasan olahraga.',
                'latitude' => -0.4910717737886814, 
                'longitude' => 117.14887188201077
            ],
            [
                'kelurahan' => 'Sempaja Selatan',
                'nama_jalan' => 'Jl. KH Wahid Hasyim',
                'panjang_meter' => 2800,
                'lebar_meter' => 8.00,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2026,
                'keterangan' => 'Jalan arteri arah utara kota.',
                'latitude' => -0.45677005813799365, 
                'longitude' => 117.15205995317447
            ],
            [
                'kelurahan' => 'Sempaja Selatan',
                'nama_jalan' => 'Jl. Perjuangan',
                'panjang_meter' => 1600,
                'lebar_meter' => 6.50,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2023,
                'keterangan' => 'Permukaan bergelombang di dekat persimpangan.',
                'latitude' => -0.4579304581697972, 
                'longitude' => 117.15811086666584
            ],
            [
                'kelurahan' => 'Sempaja Utara',
                'nama_jalan' => 'Jl. Padat Karya',
                'panjang_meter' => 1800,
                'lebar_meter' => 5.00,
                'jenis_permukaan' => 'Tanah',
                'kondisi' => 'Rusak Berat',
                'tahun_pendataan' => 2022,
                'keterangan' => 'Jalan tanah belum diperkeras, kondisi rusak berat dan sulit dilalui saat musim hujan.',
                'latitude' => -0.4246326289638298, 
                'longitude' => 117.15889036666567
            ],
            [
                'kelurahan' => 'Sungai Pinang Dalam',
                'nama_jalan' => 'Jl. Gerilya',
                'panjang_meter' => 1200,
                'lebar_meter' => 6.00,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2024,
                'keterangan' => 'Kawasan permukiman padat.',
                'latitude' => -0.4821695596639225, 
                'longitude' => 117.18007766481188
            ],
            [
                'kelurahan' => 'Gunung Lingai',
                'nama_jalan' => 'Jl. Gunung Lingai',
                'panjang_meter' => 900,
                'lebar_meter' => 5.00,
                'jenis_permukaan' => 'Paving',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2025,
                'keterangan' => 'Jalan lingkungan, baru ditata ulang.',
                'latitude' => -0.44852022895568694, 
                'longitude' => 117.1761829955019
            ],
            [
                'kelurahan' => 'Sambutan',
                'nama_jalan' => 'Jl. Sultan Sulaiman',
                'panjang_meter' => 2400,
                'lebar_meter' => 7.00,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2023,
                'keterangan' => 'Jalan kolektor arah timur kota.',
                'latitude' => -0.5174506599125273, 
                'longitude' => 117.19986899550209,
            ],
            [
                'kelurahan' => 'Makroman',
                'nama_jalan' => 'Jl. Penangkaran Buaya',
                'panjang_meter' => 1500,
                'lebar_meter' => 4.50,
                'jenis_permukaan' => 'Tanah',
                'kondisi' => 'Rusak Berat',
                'tahun_pendataan' => 2021,
                'keterangan' => 'Jalan tanah rusak berat yang menjadi akses kawasan pertanian dan berlumpur saat musim hujan.',
                'latitude' => -0.5191035587637226, 
                'longitude' => 117.23132059292146,
            ],
            [
                'kelurahan' => 'Karang Asam Ulu',
                'nama_jalan' => 'Jl. Untung Suropati',
                'panjang_meter' => 2900,
                'lebar_meter' => 9.00,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2025,
                'keterangan' => 'Jalan arteri arah barat kota.',
                'latitude' => -0.5255455304719653, 
                'longitude' => 117.11468786666592,
            ],
            [
                'kelurahan' => 'Teluk Lerong Ulu',
                'nama_jalan' => 'Jl. Cendana',
                'panjang_meter' => 1200,
                'lebar_meter' => 6.50,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2023,
                'keterangan' => '',
                'latitude' => -0.49977481660544654, 
                'longitude' => 117.11962082093976
            ],
            [
                'kelurahan' => 'Karang Asam Ilir',
                'nama_jalan' => 'Jl. Rapak Indah',
                'panjang_meter' => 1700,
                'lebar_meter' => 7.00,
                'jenis_permukaan' => 'Beton',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2024,
                'keterangan' => 'Jalan penghubung antar kawasan permukiman.',
                'latitude' => -0.503614644751101, 
                'longitude' => 117.10039731084709
            ],
            [
                'kelurahan' => 'Harapan Baru',
                'nama_jalan' => 'Jl. Cipto Mangunkusumo',
                'panjang_meter' => 3400,
                'lebar_meter' => 9.00,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2026,
                'keterangan' => 'Jalan arteri, jalur utama menuju Samarinda Seberang.',
                'latitude' => -0.5559573478356977, 
                'longitude' => 117.08655582619205
            ],
            [
                'kelurahan' => 'Rapak Dalam',
                'nama_jalan' => 'Jl. Ahmad Yani',
                'panjang_meter' => 750,
                'lebar_meter' => 4.00,
                'jenis_permukaan' => 'Tanah',
                'kondisi' => 'Rusak Berat',
                'tahun_pendataan' => 2022,
                'keterangan' => 'Jalan lingkungan, perlu penanganan segera.',
                'latitude' => -0.5361570542775774, 
                'longitude' => 117.1321798260651
            ],
            [
                'kelurahan' => 'Sungai Keledang',
                'nama_jalan' => 'Jl. Bung Tomo',
                'panjang_meter' => 3500,
                'lebar_meter' => 7.50,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2024,
                'keterangan' => 'Jalan poros Samarinda Seberang.',
                'latitude' => -0.5128390870162212, 
                'longitude' => 117.13271141084704
            ],
            [
                'kelurahan' => 'Baqa',
                'nama_jalan' => 'Jl. Slamet Riyadi',
                'panjang_meter' => 1600,
                'lebar_meter' => 6.50,
                'jenis_permukaan' => 'Aspal',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2025,
                'keterangan' => 'Kawasan permukiman dan pertokoan.',
                'latitude' => -0.5099599733235056, 
                'longitude' => 117.11778398015711
            ],
            [
                'kelurahan' => 'Mangkupalas',
                'nama_jalan' => 'Jl. Mangkupalas',
                'panjang_meter' => 900,
                'lebar_meter' => 5.00,
                'jenis_permukaan' => 'Paving',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2023,
                'keterangan' => 'Jalan lingkungan tepi Sungai Mahakam.',
                'latitude' => -0.5203315451818337, 
                'longitude' => 117.15174295317449
            ],
            [
                'kelurahan' => 'Simpang Pasir',
                'nama_jalan' => 'Jl. Simpang Pasir',
                'panjang_meter' => 1300,
                'lebar_meter' => 5.00,
                'jenis_permukaan' => 'Beton',
                'kondisi' => 'Baik',
                'tahun_pendataan' => 2025,
                'keterangan' => 'Jalan lingkungan, kondisi beton masih baik.',
                'latitude' => -0.5663315482628826, 
                'longitude' => 117.14499246481215
            ],
            [
                'kelurahan' => 'Bukuan',
                'nama_jalan' => 'Jl. Pangeran Diponegoro',
                'panjang_meter' => 1000,
                'lebar_meter' => 5.50,
                'jenis_permukaan' => 'Paving',
                'kondisi' => 'Rusak Ringan',
                'tahun_pendataan' => 2022,
                'keterangan' => 'Sebagian paving amblas.',
                'latitude' => -0.5775966998522547, 
                'longitude' => 117.20514334864691
            ],
            [
                'kelurahan' => 'Handil Bakti',
                'nama_jalan' => 'Jl. Nusa Indah',
                'panjang_meter' => 1100,
                'lebar_meter' => 4.50,
                'jenis_permukaan' => 'Tanah',
                'kondisi' => 'Rusak Berat',
                'tahun_pendataan' => 2021,
                'keterangan' => 'Masih berupa jalan tanah, belum pernah diperkeras.',
                'latitude' => -0.5963283786018788,  
                'longitude' => 117.17183854358956
            ],
        ];

        $petaKelurahan = kelurahan::pluck('id', 'nama_kelurahan');

        foreach ($jalans as $data) {
            $namaKelurahan = $data['kelurahan'];

            if (! isset($petaKelurahan[$namaKelurahan])) {
                throw new \RuntimeException(
                    "Kelurahan \"{$namaKelurahan}\" (untuk {$data['nama_jalan']}) tidak ditemukan. Periksa ejaannya di KelurahanSeeder, dan pastikan KelurahanSeeder dijalankan lebih dulu (lihat urutan di DatabaseSeeder)."
                );
            }
            unset($data['kelurahan']);
            $data['kelurahan_id'] = $petaKelurahan[$namaKelurahan];

            jalan::create($data);
        }
    }
}
