<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder konten bersifat idempotent: aman dijalankan berkali-kali (upsert berdasarkan kolom unik).
 */
abstract class BaseContentSeeder extends Seeder
{
    /**
     * @param  array<int, array<string, mixed>>  $rows  semua baris harus punya kunci yang sama
     * @param  string|array<int, string>  $uniqueBy
     */
    protected function put(string $table, array $rows, string|array $uniqueBy, bool $timestamps = true): void
    {
        if ($rows === []) {
            return;
        }

        $uniqueBy = (array) $uniqueBy;

        if ($timestamps) {
            $now = now();
            $rows = array_map(fn (array $r) => $r + ['created_at' => $now, 'updated_at' => $now], $rows);
        }

        $update = array_values(array_diff(array_keys($rows[0]), $uniqueBy, ['created_at']));

        DB::table($table)->upsert($rows, $uniqueBy, $update);
    }

    /** @return array<string, int> slug => id */
    protected function ids(string $table): array
    {
        return DB::table($table)->pluck('id', 'slug')->all();
    }
}
