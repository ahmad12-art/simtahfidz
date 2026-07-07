<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasSearchFilterSort;

class Surah extends Model
{
    use HasFactory, HasSearchFilterSort;

    protected $table = 'surah';

    protected $fillable = ['nomor_surah', 'nama_surah', 'jumlah_ayat', 'juz', 'kategori'];

    protected $searchable = ['nama_surah'];
    protected $sortable = ['nomor_surah', 'nama_surah', 'juz'];

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
}
