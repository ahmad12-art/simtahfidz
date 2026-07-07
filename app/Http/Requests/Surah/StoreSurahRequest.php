<?php

namespace App\Http\Requests\Surah;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nomor_surah' => ['required', 'integer', 'min:1', 'max:114', 'unique:surah,nomor_surah'],
            'nama_surah' => ['required', 'string', 'max:100'],
            'jumlah_ayat' => ['required', 'integer', 'min:1'],
            'juz' => ['nullable', 'integer', 'min:1', 'max:30'],
            'kategori' => ['nullable', 'in:Makkiyah,Madaniyah'],
        ];
    }
}
