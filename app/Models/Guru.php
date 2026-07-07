<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasSearchFilterSort;

class Guru extends Model
{
    use HasFactory, SoftDeletes, HasSearchFilterSort;

    protected $table = 'guru';

    protected $fillable = [
        'user_id', 'nip', 'nama', 'jenis_kelamin', 'tempat_lahir',
        'tanggal_lahir', 'alamat', 'no_hp', 'email', 'status', 'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    protected $searchable = ['nama', 'nip', 'email'];
    protected $sortable = ['nama', 'nip', 'status', 'created_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kelasWali(): HasMany
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
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

    public function getFotoUrlAttribute(): string
    {
        return $this->foto ? asset('storage/'.$this->foto) : asset('img/default-avatar.png');
    }
}
