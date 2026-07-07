<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nip' => ['required', 'string', 'max:30', 'unique:guru,nip'],
            'nama' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'status' => ['required', 'in:aktif,nonaktif'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'buat_akun' => ['nullable', 'boolean'],
            'username' => ['required_if:buat_akun,1', 'nullable', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required_if:buat_akun,1', 'nullable', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'nip.unique' => 'NIP sudah terdaftar, gunakan NIP lain.',
            'username.unique' => 'Username sudah digunakan.',
        ];
    }
}
