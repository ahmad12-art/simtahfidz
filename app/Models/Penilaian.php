<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasSearchFilterSort;

class Penilaian extends Model
{
    use HasFactory, HasSearchFilterSort;

    protected $table = 'penilaian';

    protected $fillable = [
        'santri_id', 'semester_id', 'kelancaran', 'tajwid', 'makhraj',
        'adab', 'kehadiran', 'nilai_akhir', 'predikat', 'catatan',
    ];

    protected $searchable = ['catatan'];
    protected $sortable = ['nilai_akhir', 'predikat', 'created_at'];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }
}
