<?php

namespace App\Exports;

use App\Models\Setoran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SetoranExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private array $filters = []) {}

    public function collection()
    {
        return Setoran::query()
            ->with(['santri', 'guru', 'surah'])
            ->when($this->filters['guru_id'] ?? null, fn ($q, $v) => $q->where('guru_id', $v))
            ->when($this->filters['kelas_id'] ?? null, fn ($q, $v) => $q->whereHas('santri', fn ($s) => $s->where('kelas_id', $v)))
            ->when($this->filters['tanggal_awal'] ?? null, fn ($q, $v) => $q->whereDate('tanggal', '>=', $v))
            ->when($this->filters['tanggal_akhir'] ?? null, fn ($q, $v) => $q->whereDate('tanggal', '<=', $v))
            ->orderBy('tanggal')
            ->get();
    }

    public function headings(): array
    {
        return ['Tanggal', 'Santri', 'Guru', 'Surah', 'Ayat', 'Kelancaran', 'Tajwid', 'Makhraj', 'Adab', 'Nilai Akhir', 'Status'];
    }

    public function map($row): array
    {
        return [
            $row->tanggal->format('d-m-Y'),
            $row->santri->nama,
            $row->guru->nama,
            $row->surah->nama_surah,
            "{$row->ayat_awal}-{$row->ayat_akhir}",
            $row->nilai_kelancaran,
            $row->nilai_tajwid,
            $row->nilai_makhraj,
            $row->nilai_adab,
            $row->nilai_akhir,
            $row->status,
        ];
    }
}
