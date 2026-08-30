<h1 align="center">Aplikasi pendataan jalan lingkungan</h1>

Aplikasi sederhana untuk mencatat dan mengelola data jalan lingkungan berdasarkan kelurahan dan kecamatan.

## requirment :
1. php 8.3 
2. laravel 13
3. MySQL

## langkah-langkah instalasi :
1. clone repositorynya 
2. buka cmd di folder projectnya, lalu ketik `composer install` untuk instal dependensinya
3. salin file `.env.example` setelah itu rename menjadi `.env`
4. buka file `.env` yang baru saja di rename, edit databasenya di:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tes_pkl_jalan
   DB_USERNAME=root
   DB_PASSWORD=
5. setelah selesai mengedit file `.env` jalankan perintah berikut:
```bash
php artisan key:generate
```
6. jalankan migrate dan seeder untuk membuat tabel dan datanya:
```bash
php artisan migrate:fresh --seed
```
7. buat storage link dengan mengetik:
```bash
php artisan storage:link
```
supaya foto dokumentasi bisa tampil

## cara run project :
buka terminal ketik:
```bash
php artisan serve
```
setelah itu buka browser dan buka link `http://localhost:8000`.

## Akun Demo
setelah menjalankan seeder, akun dummy berikut sudah otomatis tersedia:
* role admin
    - username: admin
    - password: password
* role petugas
    - username: petugas
    - password: password    

## Hak Akses Role

| Fitur | Admin | Petugas |
|-------|:-----:|:-------:|
| Dashboard | ✅ | ✅ | 
| CRUD Jalan | ✅ | ✅ |
| CRUD Kecamatan & Kelurahan | ✅ | ✅ |
| Peta Jalan | ✅ | ✅ |
| Dokumentasi Foto | ✅ | ✅ |
| Riwayat Kondisi | ✅ | ✅ |
| Export Laporan | ✅ | ✅ |
| CRUD User | ✅ | ❌ |
| Trash / Restore | ✅ | ❌ |
| Hapus Permanen | ✅ | ❌ |

## Daftar Fitur
fitur yang berhasil dibuat:
* Relasi database kecamatan, kelurahan, dan jalan dengan Foreign Key yang aman (restrictOnDelete).
* CRUD dan Detail kecamatan.
* CRUD dan Detail kelurahan.
* CRUD dan Detail jalan.
* Validasi form di backend dengan pesan error.
* Pencarian data jalan berdasarkan nama jalan.
* Filter data jalan berdasarkan kondisi (Baik, Rusak Ringan, Rusak Berat) dan Jenis Permukaan (Aspal, Beton, Paving, Tanah).
* Fitur Ringkasan (total jalan, jumlah per kondisi, dan perhitungan otomatis total panjang jalan).
* Desain responsif, rapi, dan konsisten menggunakan Bootstrap 5 (bisa diakses dengan baik di HP maupun Desktop).
* Penanganan error (Error Handling) dengan pesan yang ramah pengguna saat mencoba menghapus data induk yang masih berelasi.
* Penanganan data tidak ditemukan (menggunakan `findOrFail` / Halaman 404).
* Pagination data (10 baris per halaman).
* Pengurutan data terbaru tampil paling atas (`latest`).
* Soft Deletes untuk menjaga riwayat data.
* Tombol reset pencarian.

### Fitur Tambahan baru
* Login dan Logout menggunakan username dan password, dengan 2 role Admin dan Petugas.
* CRUD User khusus Admin, password di-hash, admin tidak bisa menghapus akun sendiri.
* Pemetaan lokasi jalan menggunakan Leaflet dan OpenStreetMap, klik peta untuk menentukan koordinat, marker berwarna sesuai kondisi jalan.
* Dokumentasi foto jalan, upload dan hapus foto di halaman detail jalan, validasi file gambar maksimal 2MB.
* Dashboard statistik dan grafik kondisi jalan (doughnut) serta jenis permukaan (bar) menggunakan Chart.js, dilengkapi filter wilayah.
* Riwayat kondisi jalan, mencatat histori survei jalan dengan timeline di halaman detail, tanggal survei tidak boleh di masa depan.
* Trash, Restore, dan Hapus Permanen, data yang dihapus masuk ke sampah, bisa dipulihkan atau dihapus permanen beserta file foto.
* Export laporan ke PDF dan Excel menggunakan DomPDF dan Maatwebsite Excel, laporan mengikuti filter yang sedang aktif.
* Filter dan Sorting lanjutan, filter bertingkat kecamatan ke kelurahan, rentang panjang jalan, tahun pendataan, dan sorting multi-kolom.
* Validasi data lengkap di backend dengan pesan error dalam Bahasa yang mudah di mengerti.

## Cara Menjalankan Pengujian
buka terminal ketik:
```bash
php artisan test
```

## fitur yang belum selesai:
* tidak ada

## Catatan
aplikasi ini di bantu oleh AI chatgpt, gemini, dan claude untuk:
* membantu dalam pembuatan design aplikasi 
* membantu dalam pembuatan query database
* membantu dalam pembuatan pencarian 