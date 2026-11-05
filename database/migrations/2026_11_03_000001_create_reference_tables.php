<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel referensi: data konten yang dikelola tim, bukan data pengguna.
 * Dipakai di layar 1 (landing), 2 (pilih kondisi), 3 (asesmen), 4-5 (hasil & peta), 9 (my map), 12 (tentang).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emotions', function (Blueprint $t) {
            $t->id();
            $t->string('slug', 50)->unique();
            $t->string('label', 60);
            $t->string('icon', 50)->nullable();
            $t->string('color', 20)->nullable();
            $t->unsignedSmallInteger('sort_order')->default(0);
            $t->timestamps();
        });

        Schema::create('conditions', function (Blueprint $t) {
            $t->id();
            $t->string('slug', 60)->unique();
            $t->string('title', 120);
            $t->text('description')->nullable();
            $t->string('icon', 50)->nullable();
            $t->string('color', 20)->nullable();
            $t->unsignedSmallInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        // Chip perasaan di landing mengarahkan ke kondisi yang relevan
        Schema::create('condition_emotion', function (Blueprint $t) {
            $t->foreignId('condition_id')->constrained()->cascadeOnDelete();
            $t->foreignId('emotion_id')->constrained()->cascadeOnDelete();
            $t->primary(['condition_id', 'emotion_id']);
        });

        // Layar 4-5: pola yang muncul di hasil analisis (Beban tugas, Tekanan deadline, ...)
        // Kolom now_action / can_wait / watch_note mengisi 3 dari 4 kotak "Peta Kondisiku".
        Schema::create('patterns', function (Blueprint $t) {
            $t->id();
            $t->string('slug', 60)->unique();
            $t->string('title', 120);
            $t->text('description');
            $t->string('icon', 50)->nullable();
            $t->string('color', 20)->nullable();
            $t->string('now_action', 255);   // "Yang bisa dilakukan sekarang"
            $t->string('can_wait', 255);     // "Yang tidak perlu diselesaikan sekarang"
            $t->string('watch_note', 255);   // "Yang perlu diperhatikan"
            $t->unsignedSmallInteger('sort_order')->default(0);
            $t->timestamps();
        });

        // Layar 3: butir checklist. Tiap sinyal menyumbang skor ke satu pola.
        // pattern_id null = sinyal keselamatan (tidak masuk skor, hanya memicu tampilan bantuan).
        Schema::create('signals', function (Blueprint $t) {
            $t->id();
            $t->string('slug', 60)->unique();
            $t->string('label', 200);
            $t->foreignId('pattern_id')->nullable()->constrained()->nullOnDelete();
            $t->unsignedTinyInteger('weight')->default(1);
            $t->boolean('is_red_flag')->default(false);
            $t->timestamps();
        });

        // Sinyal mana yang tampil untuk kondisi mana, beserta urutannya
        Schema::create('condition_signal', function (Blueprint $t) {
            $t->foreignId('condition_id')->constrained()->cascadeOnDelete();
            $t->foreignId('signal_id')->constrained()->cascadeOnDelete();
            $t->unsignedSmallInteger('sort_order')->default(0);
            $t->primary(['condition_id', 'signal_id']);
        });

        // Layar 9: kategori area hidup di "Pola Pikiranmu" (Kuliah, Keluarga, Sosial, ...)
        Schema::create('life_areas', function (Blueprint $t) {
            $t->id();
            $t->string('slug', 50)->unique();
            $t->string('label', 60);
            $t->string('color', 20)->nullable();
            $t->unsignedSmallInteger('sort_order')->default(0);
            $t->timestamps();
        });

        // Layar 1 & 12: teks landing, tentang, keunggulan, disclaimer. Disimpan sebagai JSON per kunci.
        Schema::create('site_contents', function (Blueprint $t) {
            $t->id();
            $t->string('key', 100)->unique();
            $t->json('value');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_contents');
        Schema::dropIfExists('life_areas');
        Schema::dropIfExists('condition_signal');
        Schema::dropIfExists('signals');
        Schema::dropIfExists('patterns');
        Schema::dropIfExists('condition_emotion');
        Schema::dropIfExists('conditions');
        Schema::dropIfExists('emotions');
    }
};
