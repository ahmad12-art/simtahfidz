<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasSearchFilterSort;

class TargetHafalan extends Model
{
    use HasFactory, HasSearchFilterSort;

    protected $table = 'target_hafalan';

    protected $fillable = [
        'santri_id', 'guru_id', 'surah_id', 'ayat_awal', 'ayat_akhir',
        'tanggal_mulai', 'deadline', 'status', 'persentase_progress', 'catatan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'deadline' => 'date',
        'persentase_progress' => 'decimal:2',
    ];

    protected $searchable = ['catatan'];
    protected $sortable = ['tanggal_mulai', 'deadline', 'status', 'persentase_progress'];

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

    public function setoran(): HasMany
    {
        return $this->hasMany(Setoran::class);
    }

    public function scopeStatus($query, ?string $status)
    {
        return filled($status) ? $query->where('status', $status) : $query;
    }
}
