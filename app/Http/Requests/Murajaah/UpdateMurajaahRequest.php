<?php

namespace App\Http\Requests\Murajaah;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMurajaahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isGuru() || $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'santri_id' => ['required', 'exists:santri,id'],
            'guru_id' => ['required', 'exists:guru,id'],
            'surah_id' => ['required', 'exists:surah,id'],
            'tanggal' => ['required', 'date'],
            'ayat_awal' => ['required', 'integer', 'min:1'],
            'ayat_akhir' => ['required', 'integer', 'gte:ayat_awal'],
            'nilai_kelancaran' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_tajwid' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_makhraj' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'in:lancar,mengulang,belum_lancar'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
