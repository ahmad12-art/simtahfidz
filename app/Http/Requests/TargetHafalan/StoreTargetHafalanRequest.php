<?php

namespace App\Http\Requests\TargetHafalan;

use Illuminate\Foundation\Http\FormRequest;

class StoreTargetHafalanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin() || $this->user()->isGuru();
    }

    public function rules(): array
    {
        return [
            'santri_id' => ['required', 'exists:santri,id'],
            'guru_id' => ['required', 'exists:guru,id'],
            'surah_id' => ['required', 'exists:surah,id'],
            'ayat_awal' => ['required', 'integer', 'min:1'],
            'ayat_akhir' => ['required', 'integer', 'gte:ayat_awal'],
            'tanggal_mulai' => ['required', 'date'],
            'deadline' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
