<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasSearchFilterSort;

class Kelas extends Model
{
    use HasFactory, HasSearchFilterSort;

    protected $table = 'kelas';

    protected $fillable = ['wali_kelas_id', 'tahun_ajaran_id', 'nama_kelas', 'tingkat'];

    protected $searchable = ['nama_kelas', 'tingkat'];
    protected $sortable = ['nama_kelas', 'tingkat', 'created_at'];

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function santri(): HasMany
    {
        return $this->hasMany(Santri::class);
    }
}
