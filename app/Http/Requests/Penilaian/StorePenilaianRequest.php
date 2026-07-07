<?php

namespace App\Http\Requests\Penilaian;

use Illuminate\Foundation\Http\FormRequest;

class StorePenilaianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isGuru() || $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'santri_id' => ['required', 'exists:santri,id'],
            'semester_id' => ['required', 'exists:semester,id'],
            'kelancaran' => ['required', 'numeric', 'min:0', 'max:100'],
            'tajwid' => ['required', 'numeric', 'min:0', 'max:100'],
            'makhraj' => ['required', 'numeric', 'min:0', 'max:100'],
            'adab' => ['required', 'numeric', 'min:0', 'max:100'],
            'kehadiran' => ['required', 'numeric', 'min:0', 'max:100'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
