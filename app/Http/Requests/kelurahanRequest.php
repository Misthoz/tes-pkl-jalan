<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class kelurahanRequest extends FormRequest
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
            'kecamatan_id' => 'required|exists:kecamatan,id,deleted_at,NULL',
            'nama_kelurahan' => 'required|string|max:100|unique:kelurahan,nama_kelurahan,' . $this->route('kelurahan')?->id,
        ];
    }

    public function messages(): array
    {
        return [
            'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
            'kecamatan_id.exists' => 'Kecamatan yang dipilih tidak valid atau sudah dipindahkan ke trash.',
            'nama_kelurahan.required' => 'Nama kelurahan wajib diisi.',
            'nama_kelurahan.unique' => 'Nama kelurahan sudah terdaftar.',
            'nama_kelurahan.max' => 'Nama kelurahan maksimal 100 karakter.',
        ];
    }
}
