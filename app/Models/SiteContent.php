<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteContent extends Model
{
    protected $fillable = ['key', 'value'];

    protected function casts(): array
    {
        return ['value' => 'array'];
    }

    /**
     * Ambil satu blok teks, contoh: SiteContent::get('landing.hero')['headline'].
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return static::allCached()[$key] ?? $default;
    }

    /**
     * Semua blok sekaligus (key => value), dicache 1 jam supaya halaman publik tidak query tiap request.
     * Cache dihapus otomatis saat ada baris yang disimpan atau dihapus.
     *
     * @return array<string, mixed>
     */
    public static function allCached(): array
    {
        return Cache::remember('site_contents.all', 3600, fn () => static::query()
            ->get(['key', 'value'])
            ->mapWithKeys(fn (self $row) => [$row->key => $row->value])
            ->all());
    }

    protected static function booted(): void
    {
        $forget = fn () => Cache::forget('site_contents.all');
        static::saved($forget);
        static::deleted($forget);
    }
}
