<?php

namespace App\Exports;

use App\Models\Penilaian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenilaianExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private array $filters = []) {}

    public function collection()
    {
        return Penilaian::query()
            ->with(['santri.kelas', 'semester'])
            ->when($this->filters['semester_id'] ?? null, fn ($q, $v) => $q->where('semester_id', $v))
            ->get();
    }

    public function headings(): array
    {
        return ['Santri', 'Kelas', 'Semester', 'Kelancaran', 'Tajwid', 'Makhraj', 'Adab', 'Kehadiran', 'Nilai Akhir', 'Predikat'];
    }

    public function map($row): array
    {
        return [
            $row->santri->nama,
            $row->santri->kelas?->nama_kelas,
            $row->semester->nama,
            $row->kelancaran,
            $row->tajwid,
            $row->makhraj,
            $row->adab,
            $row->kehadiran,
            $row->nilai_akhir,
            $row->predikat,
        ];
    }
}
