<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Konten mode bantuan: layar 5 (pilih bagian), 6 (pertanyaan mode), 7 (langkah kecil), 8 (ruang tenang),
 * dan "Mode Bantuan" di dashboard.
 * Mode "masalah sama orang" (layar 10) sengaja tidak ada karena dicoret di prototipe.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 4 mode: tugas, jeda, refleksi, bantuan
        Schema::create('modes', function (Blueprint $t) {
            $t->id();
            $t->string('slug', 50)->unique();
            $t->string('title', 80);             // "Mode Tugas"
            $t->string('tagline', 160);          // "Bikin masalah jadi lebih kecil"
            $t->string('help_label', 120);       // kartu di Peta Kondisiku: "Bikin masalah ini lebih kecil"
            $t->string('icon', 50)->nullable();
            $t->string('color', 20)->nullable();
            $t->string('closing_title', 160);    // layar 8
            $t->text('closing_message');
            $t->unsignedSmallInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        // Layar 7: satu rencana = satu daftar langkah kecil
        Schema::create('recommendation_plans', function (Blueprint $t) {
            $t->id();
            $t->foreignId('mode_id')->constrained()->cascadeOnDelete();
            $t->string('slug', 80)->unique();
            $t->string('title', 160);            // "Langkah kecil untuk mulai"
            $t->string('intro', 255);            // "Kamu bisa mulai dari salah satu langkah ini."
            $t->timestamps();
        });

        Schema::create('recommendation_steps', function (Blueprint $t) {
            $t->id();
            $t->foreignId('plan_id')->constrained('recommendation_plans')->cascadeOnDelete();
            $t->unsignedSmallInteger('position');
            $t->string('instruction', 255);
            $t->unsignedSmallInteger('estimated_minutes')->nullable();
            $t->timestamps();
            $t->unique(['plan_id', 'position']);
        });

        // Layar 6: "Aku stuck sama tugas - Apa yang paling bikin kamu nggak mulai?"
        Schema::create('mode_questions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('mode_id')->constrained()->cascadeOnDelete();
            $t->string('prompt', 200);
            $t->string('helper', 255)->nullable();
            $t->unsignedSmallInteger('sort_order')->default(1);
            $t->timestamps();
            $t->unique(['mode_id', 'sort_order']);
        });

        // Jawaban menentukan rencana langkah kecil yang ditampilkan
        Schema::create('mode_question_options', function (Blueprint $t) {
            $t->id();
            $t->foreignId('mode_question_id')->constrained('mode_questions')->cascadeOnDelete();
            $t->string('label', 200);
            $t->foreignId('recommendation_plan_id')->nullable()
                ->constrained('recommendation_plans')->nullOnDelete();
            $t->unsignedSmallInteger('sort_order')->default(1);
            $t->timestamps();
            $t->unique(['mode_question_id', 'sort_order']);
        });

        // Mode Bantuan: daftar kontak. is_verified false = wajib dicek tim sebelum rilis.
        Schema::create('support_resources', function (Blueprint $t) {
            $t->id();
            $t->string('slug', 80)->unique();
            $t->string('name', 160);
            $t->enum('category', ['darurat', 'hotline', 'kampus', 'profesional', 'komunitas']);
            $t->text('description');
            $t->string('phone', 40)->nullable();
            $t->string('url', 255)->nullable();
            $t->string('availability', 120)->nullable();
            $t->boolean('is_verified')->default(false);
            $t->boolean('is_active')->default(true);
            $t->unsignedSmallInteger('sort_order')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_resources');
        Schema::dropIfExists('mode_question_options');
        Schema::dropIfExists('mode_questions');
        Schema::dropIfExists('recommendation_steps');
        Schema::dropIfExists('recommendation_plans');
        Schema::dropIfExists('modes');
    }
};
