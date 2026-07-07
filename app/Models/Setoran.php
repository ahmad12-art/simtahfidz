<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasSearchFilterSort;

class Setoran extends Model
{
    use HasFactory, HasSearchFilterSort;

    protected $table = 'setoran';

    protected $fillable = [
        'target_hafalan_id', 'santri_id', 'guru_id', 'surah_id', 'tanggal',
        'ayat_awal', 'ayat_akhir', 'nilai_kelancaran', 'nilai_tajwid',
        'nilai_makhraj', 'nilai_adab', 'nilai_akhir', 'status', 'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    protected $searchable = ['catatan'];
    protected $sortable = ['tanggal', 'nilai_akhir', 'status'];

    public function targetHafalan(): BelongsTo
    {
        return $this->belongsTo(TargetHafalan::class);
    }

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function surah(): BelongsTo
    {
        return $this->belongsTo(Surah::class);
    }

    public function getPredikatAttribute(): string
    {
        return match (true) {
            $this->nilai_akhir >= 90 => 'A',
            $this->nilai_akhir >= 80 => 'B',
            $this->nilai_akhir >= 70 => 'C',
            default => 'D',
        };
    }
}
