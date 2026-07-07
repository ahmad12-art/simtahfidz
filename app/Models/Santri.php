<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasSearchFilterSort;

class Santri extends Model
{
    use HasFactory, SoftDeletes, HasSearchFilterSort;

    protected $table = 'santri';

    protected $fillable = [
        'kelas_id', 'nis', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'alamat', 'nama_wali', 'no_hp_wali', 'status', 'foto', 'qr_code',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    protected $searchable = ['nama', 'nis', 'nama_wali'];
    protected $sortable = ['nama', 'nis', 'status', 'created_at'];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function targetHafalan(): HasMany
    {
        return $this->hasMany(TargetHafalan::class);
    }

    public function setoran(): HasMany
    {
        return $this->hasMany(Setoran::class);
    }

    public function murajaah(): HasMany
    {
        return $this->hasMany(Murajaah::class);
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }

    public function getFotoUrlAttribute(): string
    {
        return $this->foto ? asset('storage/'.$this->foto) : asset('img/default-avatar.png');
    }
}
