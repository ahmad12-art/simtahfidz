<?php

namespace App\Exports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SantriExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Santri::with('kelas')->orderBy('nama')->get();
    }

    public function headings(): array
    {
        return ['NIS', 'Nama', 'Jenis Kelamin', 'Kelas', 'Nama Wali', 'No HP Wali', 'Status'];
    }

    public function map($row): array
    {
        return [
            $row->nis,
            $row->nama,
            $row->jenis_kelamin,
            $row->kelas?->nama_kelas,
            $row->nama_wali,
            $row->no_hp_wali,
            $row->status,
        ];
    }
}
