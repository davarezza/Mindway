<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SupportResource extends Model
{
    protected $fillable = [
        'slug', 'name', 'category', 'description', 'phone', 'url',
        'availability', 'is_verified', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Yang boleh tampil ke pengguna: aktif DAN sudah diverifikasi tim.
     * Kontak yang belum diverifikasi sengaja tidak tampil di produksi.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true)->where('is_verified', true)->orderBy('sort_order');
    }
}
