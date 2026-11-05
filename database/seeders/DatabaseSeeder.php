<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Hanya konten. Riwayat pengguna disimpan di localStorage browser, bukan di database.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting: pola -> sinyal -> kondisi, lalu mode (bergantung pada tabel referensi).
        $this->call([
            ReferenceSeeder::class,
            ModeSeeder::class,
            SupportSeeder::class,
        ]);
    }
}
