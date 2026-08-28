<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class jalanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kelurahan_id' => 'required|exists:kelurahan,id,deleted_at,NULL',
            'nama_jalan' => 'required|string|max:150|unique:jalan,nama_jalan,' . $this->route('jalan')?->id,
            'panjang_meter' => 'required|integer|min:1|max:2147483647',
            'lebar_meter' => 'required|numeric|min:0.01|max:999.99',
            'jenis_permukaan' => 'required|in:Aspal,Beton,Paving,Tanah',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'tahun_pendataan' => 'required|integer|min:2000|max:' . date('Y'),
            'keterangan' => 'nullable|string|max:16383',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];
    }

    /**
     * Pesan validasi dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'kelurahan_id.required' => 'Kelurahan wajib dipilih.',
            'kelurahan_id.exists' => 'Kelurahan yang dipilih tidak valid atau sudah dipindahkan ke trash.',
            'nama_jalan.required' => 'Nama jalan wajib diisi.',
            'nama_jalan.unique' => 'Nama jalan sudah terdaftar.',
            'panjang_meter.required' => 'Panjang jalan wajib diisi.',
            'panjang_meter.min' => 'Panjang jalan harus lebih besar dari 0.',
            'panjang_meter.max' => 'Panjang jalan terlalu besar. Maksimal 2.147.483.647 meter.',
            'lebar_meter.required' => 'Lebar jalan wajib diisi.',
            'lebar_meter.min' => 'Lebar jalan harus lebih besar dari 0.',
            'lebar_meter.max' => 'Lebar jalan terlalu besar. Maksimal 999,99 meter.',
            'jenis_permukaan.required' => 'Jenis permukaan wajib dipilih.',
            'jenis_permukaan.in' => 'Jenis permukaan hanya boleh: Aspal, Beton, Paving, atau Tanah.',
            'kondisi.required' => 'Kondisi wajib dipilih.',
            'kondisi.in' => 'Kondisi hanya boleh: Baik, Rusak Ringan, atau Rusak Berat.',
            'tahun_pendataan.required' => 'Tahun pendataan wajib diisi.',
            'tahun_pendataan.min' => 'Tahun pendataan minimal 2000.',
            'tahun_pendataan.max' => 'Tahun pendataan tidak boleh melebihi tahun berjalan.',
            'keterangan.max' => 'Keterangan terlalu panjang. Maksimal 16.383 karakter.',
            'latitude.between' => 'Latitude harus berada di antara -90 dan 90.',
            'longitude.between' => 'Longitude harus berada di antara -180 dan 180.',
        ];
    }
}
