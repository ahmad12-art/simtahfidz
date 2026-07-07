<?php

namespace App\Http\Requests\Kelas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nama_kelas' => ['required', 'string', 'max:100'],
            'tingkat' => ['nullable', 'string', 'max:50'],
            'wali_kelas_id' => ['nullable', 'exists:guru,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
        ];
    }
}
