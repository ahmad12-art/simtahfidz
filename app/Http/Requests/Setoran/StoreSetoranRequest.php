<?php

namespace App\Http\Requests\Setoran;

use Illuminate\Foundation\Http\FormRequest;

class StoreSetoranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isGuru() || $this->user()->isAdmin();
    }

    public function rules(): array
    {
        // FIX #3: Guru hanya boleh menyimpan setoran atas namanya sendiri.
        // Admin boleh memilih guru_id siapapun.
        $guruIdRules = ['required', 'exists:guru,id'];
        if (! $this->user()->isAdmin()) {
            $guruIdRules[] = \Illuminate\Validation\Rule::in([$this->user()->guru?->id]);
        }

        return [
            'target_hafalan_id' => ['nullable', 'exists:target_hafalan,id'],
            'santri_id' => ['required', 'exists:santri,id'],
            'guru_id' => $guruIdRules,
            'surah_id' => ['required', 'exists:surah,id'],
            'tanggal' => ['required', 'date'],
            'ayat_awal' => ['required', 'integer', 'min:1'],
            'ayat_akhir' => ['required', 'integer', 'gte:ayat_awal'],
            'nilai_kelancaran' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_tajwid' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_makhraj' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_adab' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'in:lancar,mengulang,belum_lancar'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
