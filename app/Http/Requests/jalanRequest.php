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
            'kelurahan_id' => 'required|exists:kelurahan,id',
            'nama_jalan' => 'required|string|max:150|unique:jalan,nama_jalan,' . $this->route('jalan')?->id,
            'panjang_meter' => 'required|integer|min:1',
            'lebar_meter' => 'required|numeric|min:0.01',
            'jenis_permukaan' => 'required|in:Aspal,Beton,Paving,Tanah',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'tahun_pendataan' => 'required|integer|min:2000|max:' . date('Y'),
            'keterangan' => 'nullable|string',
        ];
    }
}
