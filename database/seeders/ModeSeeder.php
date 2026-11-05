<?php

namespace Database\Seeders;

/**
 * 4 mode bantuan beserta pertanyaan, opsi jawaban, dan rencana langkah kecil (layar 5-8).
 */
class ModeSeeder extends BaseContentSeeder
{
    public function run(): void
    {
        $this->put('modes', [
            [
                'slug' => 'tugas', 'title' => 'Mode Tugas', 'tagline' => 'Bikin masalah jadi lebih kecil',
                'help_label' => 'Bikin masalah ini lebih kecil', 'icon' => 'clipboard-check', 'color' => '#E8637F', 'sort_order' => 1, 'is_active' => true,
                'closing_title' => 'Kamu sudah melakukan satu hal penting hari ini.',
                'closing_message' => 'Hari ini kamu nggak harus menyelesaikan semuanya. Kamu sudah menentukan satu hal yang bisa kamu tangani sekarang. Itu sudah cukup.',
            ],
            [
                'slug' => 'jeda', 'title' => 'Mode Jeda', 'tagline' => 'Jeda sejenak, tarik napas',
                'help_label' => 'Aku cuma butuh jeda', 'icon' => 'pause-circle', 'color' => '#2F9E7B', 'sort_order' => 2, 'is_active' => true,
                'closing_title' => 'Kamu sudah memberi dirimu jeda.',
                'closing_message' => 'Istirahat bukan berarti menyerah. Kamu boleh kembali kapan pun kamu merasa siap.',
            ],
            [
                'slug' => 'refleksi', 'title' => 'Mode Refleksi', 'tagline' => 'Pahami apa yang kamu rasakan',
                'help_label' => 'Aku mau memahami perasaanku', 'icon' => 'book-open', 'color' => '#9B6BD8', 'sort_order' => 3, 'is_active' => true,
                'closing_title' => 'Kamu sudah meluangkan waktu untuk dirimu.',
                'closing_message' => 'Nggak harus ketemu jawabannya hari ini. Menamai perasaan saja sudah langkah yang berarti.',
            ],
            [
                'slug' => 'bantuan', 'title' => 'Mode Bantuan', 'tagline' => 'Cari dukungan yang kamu butuh',
                'help_label' => 'Aku mau cari bantuan', 'icon' => 'life-buoy', 'color' => '#4C7BE8', 'sort_order' => 4, 'is_active' => true,
                'closing_title' => 'Mencari bantuan itu langkah yang berani.',
                'closing_message' => 'Kamu nggak harus melewati ini sendirian. Kamu boleh kembali ke sini kapan pun.',
            ],
        ], 'slug');

        $modes = $this->ids('modes');

        // plan slug => [mode, judul, intro, [[langkah, menit], ...]]
        $plans = [
            // ---- Mode Tugas
            'tugas-takut-salah' => ['tugas', 'Mulai dari versi yang belum bagus', 'Versi pertama memang boleh jelek. Tugasnya cuma ada di kertas.', [
                ['Buka dokumen tugasmu', 1],
                ['Tulis kalimat pertama yang jelek dengan sengaja', 5],
                ['Lanjut menulis 10 menit tanpa menghapus apa pun', 10],
                ['Simpan, lalu tutup. Penyempurnaan dilakukan nanti', 1],
            ]],
            'tugas-mulai-kecil' => ['tugas', 'Langkah kecil untuk mulai', 'Kamu bisa mulai dari salah satu langkah ini.', [
                ['Buka dokumen tugas kamu', 1],
                ['Tulis judul sementara', 2],
                ['Buat 3 poin utama yang kamu tahu', 5],
                ['Cari 1 referensi atau sumber', 10],
                ['Istirahat 10 menit kalau sudah terlalu capek', 10],
            ]],
            'tugas-pilih-satu' => ['tugas', 'Pilih satu saja dulu', 'Dari semua yang menumpuk, cukup satu yang dikerjakan sekarang.', [
                ['Tulis semua tugasmu di satu tempat, tanpa diurutkan', 5],
                ['Lingkari satu yang deadline-nya paling dekat', 2],
                ['Tulis langkah pertamanya dalam satu kalimat', 2],
                ['Kerjakan langkah itu selama 15 menit', 15],
            ]],
            'tugas-energi-rendah' => ['tugas', 'Versi hemat tenaga', 'Kalau energi lagi rendah, targetnya diturunkan, bukan dipaksakan.', [
                ['Minum air dan duduk dengan nyaman', 3],
                ['Pilih bagian tugas yang paling ringan', 2],
                ['Kerjakan hanya 10 menit, pakai timer', 10],
                ['Berhenti saat timer bunyi, lanjut kalau masih kuat', 1],
            ]],

            // ---- Mode Jeda
            'jeda-napas' => ['jeda', 'Menenangkan pikiran yang ramai', 'Beberapa menit cukup untuk menurunkan tempo.', [
                ['Duduk dan letakkan kedua kaki di lantai', 1],
                ['Tarik napas 4 hitungan, tahan 4, buang 6. Ulangi 5 kali', 3],
                ['Sebutkan 3 benda yang kamu lihat di sekitarmu', 1],
                ['Minum air pelan-pelan', 1],
            ]],
            'jeda-badan' => ['jeda', 'Melepas ketegangan badan', 'Badan yang tegang ikut membuat pikiran terasa berat.', [
                ['Berdiri dan angkat bahu ke arah telinga, lalu turunkan. Ulangi 5 kali', 2],
                ['Putar leher pelan ke kiri dan ke kanan', 2],
                ['Regangkan tangan ke atas selama 10 detik', 1],
                ['Jalan pelan di ruangan selama 3 menit', 3],
            ]],
            'jeda-layar' => ['jeda', 'Istirahat dari layar', 'Beri matamu dan pikiranmu jeda dari notifikasi.', [
                ['Taruh ponsel di luar jangkauan tangan', 1],
                ['Pandang sesuatu yang jauh, misalnya jendela, selama 1 menit', 1],
                ['Lakukan satu hal tanpa layar, misalnya minum teh atau menata meja', 10],
            ]],

            // ---- Mode Refleksi
            'refleksi-namai' => ['refleksi', 'Memberi nama pada perasaan', 'Perasaan yang sudah punya nama biasanya terasa lebih bisa dihadapi.', [
                ['Tarik napas dan rasakan bagian tubuh mana yang paling terasa', 2],
                ['Pilih kata yang paling mendekati: capek, cemas, kesal, sedih, atau bingung', 1],
                ['Tulis satu kalimat: "Aku merasa ... karena ..."', 3],
                ['Kalau belum ketemu karenanya, nggak apa-apa. Cukup berhenti di sini', 1],
            ]],
            'refleksi-pemicu' => ['refleksi', 'Mencari pemicu', 'Kamu nggak harus menemukan penyebab pastinya, cukup melihat petunjuknya.', [
                ['Ingat kapan perasaan ini mulai terasa lebih kuat hari ini', 2],
                ['Tulis apa yang terjadi sebelum itu', 3],
                ['Pilih area hidupnya: kuliah, keluarga, sosial, atau diri sendiri', 1],
                ['Simpan sebagai catatan untuk My Map', 1],
            ]],
            'refleksi-tulis' => ['refleksi', 'Menuliskan yang kepikiran', 'Pikiran yang ditulis biasanya berhenti berputar di kepala.', [
                ['Tulis hal yang kepikiran selama 3 menit, tanpa menyusun kalimat', 3],
                ['Baca ulang, lalu garis bawahi satu hal yang paling mengganggu', 2],
                ['Tulis satu hal kecil yang bisa kamu lakukan soal itu, atau tulis "belum bisa sekarang"', 2],
            ]],

            // ---- Mode Bantuan
            'bantuan-cerita' => ['bantuan', 'Bercerita ke orang terdekat', 'Kamu nggak perlu cerita semuanya. Cukup mulai dari satu kalimat.', [
                ['Pilih satu orang yang membuatmu merasa aman', 2],
                ['Kirim pesan singkat, contoh: "Boleh ngobrol sebentar? Aku lagi nggak baik-baik aja."', 2],
                ['Kalau belum dibalas, tarik napas dan lakukan satu hal ringan sambil menunggu', 5],
            ]],
            'bantuan-profesional' => ['bantuan', 'Bicara dengan konselor atau profesional', 'Berbicara dengan profesional adalah hal yang wajar dan bisa dimulai dari mana saja.', [
                ['Lihat daftar layanan di bawah dan pilih satu yang paling mudah kamu jangkau', 5],
                ['Tulis 2-3 hal yang ingin kamu ceritakan supaya nggak lupa', 5],
                ['Hubungi atau buat janji temu', 5],
            ]],
            'bantuan-darurat' => ['bantuan', 'Kalau kamu merasa nggak aman sekarang', 'Keselamatanmu yang utama. Lakukan ini satu per satu.', [
                ['Kalau kamu dalam bahaya langsung, hubungi 112 sekarang', 1],
                ['Pindah ke tempat yang ada orang lain, atau minta seseorang menemanimu', 2],
                ['Jauhkan benda yang bisa kamu pakai untuk menyakiti diri sendiri', 2],
                ['Hubungi layanan konseling di daftar bantuan dan sampaikan apa yang kamu rasakan', 5],
            ]],
        ];

        $planRows = [];
        foreach ($plans as $slug => [$mode, $title, $intro]) {
            $planRows[] = ['mode_id' => $modes[$mode], 'slug' => $slug, 'title' => $title, 'intro' => $intro];
        }
        $this->put('recommendation_plans', $planRows, 'slug');

        $planIds = $this->ids('recommendation_plans');

        $stepRows = [];
        foreach ($plans as $slug => [, , , $steps]) {
            foreach ($steps as $i => [$text, $minutes]) {
                $stepRows[] = [
                    'plan_id' => $planIds[$slug], 'position' => $i + 1,
                    'instruction' => $text, 'estimated_minutes' => $minutes,
                ];
            }
        }
        $this->put('recommendation_steps', $stepRows, ['plan_id', 'position']);

        // Pertanyaan per mode + opsi yang mengarah ke rencana
        $questions = [
            'tugas' => ['Aku stuck sama tugas', 'Apa yang paling bikin kamu nggak mulai?', [
                ['Takut salah', 'tugas-takut-salah'],
                ['Nggak tahu mulai dari mana', 'tugas-mulai-kecil'],
                ['Kebanyakan tugas', 'tugas-pilih-satu'],
                ['Nggak punya energi', 'tugas-energi-rendah'],
            ]],
            'jeda' => ['Aku butuh jeda', 'Jeda seperti apa yang cocok sekarang?', [
                ['Pikiranku terlalu ramai', 'jeda-napas'],
                ['Badanku terasa tegang dan capek', 'jeda-badan'],
                ['Aku butuh jauh dari layar sebentar', 'jeda-layar'],
            ]],
            'refleksi' => ['Aku mau memahami perasaanku', 'Kamu mau mulai dari mana?', [
                ['Aku nggak tahu apa nama perasaan ini', 'refleksi-namai'],
                ['Aku tahu rasanya, tapi nggak tahu pemicunya', 'refleksi-pemicu'],
                ['Aku kepikiran terus soal satu hal', 'refleksi-tulis'],
            ]],
            'bantuan' => ['Aku mau cari bantuan', 'Bantuan seperti apa yang kamu cari?', [
                ['Aku mau cerita ke orang terdekat', 'bantuan-cerita'],
                ['Aku mau bicara dengan konselor atau profesional', 'bantuan-profesional'],
                ['Aku lagi merasa nggak aman', 'bantuan-darurat'],
            ]],
        ];

        $qRows = [];
        foreach ($questions as $mode => [$prompt, $helper]) {
            $qRows[] = ['mode_id' => $modes[$mode], 'prompt' => $prompt, 'helper' => $helper, 'sort_order' => 1];
        }
        $this->put('mode_questions', $qRows, ['mode_id', 'sort_order']);

        $qIds = \Illuminate\Support\Facades\DB::table('mode_questions')
            ->where('sort_order', 1)->pluck('id', 'mode_id')->all();

        $oRows = [];
        foreach ($questions as $mode => [, , $options]) {
            foreach ($options as $i => [$label, $plan]) {
                $oRows[] = [
                    'mode_question_id' => $qIds[$modes[$mode]], 'label' => $label,
                    'recommendation_plan_id' => $planIds[$plan], 'sort_order' => $i + 1,
                ];
            }
        }
        $this->put('mode_question_options', $oRows, ['mode_question_id', 'sort_order']);
    }
}
