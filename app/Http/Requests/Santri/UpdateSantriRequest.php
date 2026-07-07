<?php

namespace App\Http\Requests\Santri;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSantriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        $santriId = $this->route('santri')->id;

        return [
            'kelas_id' => ['nullable', 'exists:kelas,id'],
            'nis' => ['required', 'string', 'max:30', Rule::unique('santri', 'nis')->ignore($santriId)],
            'nama' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'nama_wali' => ['nullable', 'string', 'max:150'],
            'no_hp_wali' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:aktif,lulus,pindah,nonaktif'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
