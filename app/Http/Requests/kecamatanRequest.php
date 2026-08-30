<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class kecamatanRequest extends FormRequest
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
            'nama_kecamatan' => 'required|string|max:100|unique:kecamatan,nama_kecamatan,' . $this->route('kecamatan')?->id,
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kecamatan.required' => 'Nama kecamatan wajib diisi.',
            'nama_kecamatan.unique' => 'Nama kecamatan sudah terdaftar.',
            'nama_kecamatan.max' => 'Nama kecamatan maksimal 100 karakter.',
        ];
    }
}
