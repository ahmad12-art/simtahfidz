<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Reusable query helpers for index pages: search, filter, sort.
 * Dipakai oleh model-model yang menampilkan halaman listing dengan
 * kotak pencarian, dropdown filter, dan sorting kolom.
 */
trait HasSearchFilterSort
{
    /**
     * Scope pencarian sederhana pada kolom-kolom yang ditentukan model
     * melalui properti $searchable = ['nama', 'nis', ...].
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term) || empty($this->searchable)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            foreach ($this->searchable as $column) {
                $q->orWhere($column, 'like', "%{$term}%");
            }
        });
    }

    /**
     * Scope filter generik: menerima array ['kolom' => nilai] dan hanya
     * menerapkan where jika nilai tidak kosong.
     */
    public function scopeApplyFilters(Builder $query, array $filters = []): Builder
    {
        foreach ($filters as $column => $value) {
            if (filled($value)) {
                $query->where($column, $value);
            }
        }

        return $query;
    }

    /**
     * Scope sorting generik dengan whitelist kolom agar aman dari SQL injection
     * lewat query string ?sort=...
     */
    public function scopeApplySort(Builder $query, ?string $sort, ?string $direction = 'asc'): Builder
    {
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';
        $allowed = $this->sortable ?? [];

        if ($sort && in_array($sort, $allowed, true)) {
            return $query->orderBy($sort, $direction);
        }

        return $query->latest();
    }
}
