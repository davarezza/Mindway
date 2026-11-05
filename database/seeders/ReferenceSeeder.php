<?php

namespace Database\Seeders;

/**
 * Emosi, area hidup, pola, sinyal, dan kondisi (layar 1-5, 9).
 */
class ReferenceSeeder extends BaseContentSeeder
{
    public function run(): void
    {
        $this->emotions();
        $this->lifeAreas();
        $this->patterns();
        $this->signals();
        $this->conditions();
    }

    private function emotions(): void
    {
        $this->put('emotions', [
            ['slug' => 'capek',  'label' => 'Capek',  'icon' => 'battery-low',  'color' => '#8B7FE8', 'sort_order' => 1],
            ['slug' => 'cemas',  'label' => 'Cemas',  'icon' => 'wind',         'color' => '#5B9BE8', 'sort_order' => 2],
            ['slug' => 'kesal',  'label' => 'Kesal',  'icon' => 'flame',        'color' => '#F0A04B', 'sort_order' => 3],
            ['slug' => 'sedih',  'label' => 'Sedih',  'icon' => 'cloud-rain',   'color' => '#4C63C9', 'sort_order' => 4],
            ['slug' => 'bingung', 'label' => 'Bingung', 'icon' => 'help-circle', 'color' => '#6E8BE8', 'sort_order' => 5],
        ], 'slug');
    }

    private function lifeAreas(): void
    {
        $this->put('life_areas', [
            ['slug' => 'kuliah',       'label' => 'Kuliah',       'color' => '#2F9E7B', 'sort_order' => 1],
            ['slug' => 'keluarga',     'label' => 'Keluarga',     'color' => '#E8A04B', 'sort_order' => 2],
            ['slug' => 'sosial',       'label' => 'Sosial',       'color' => '#9B6BD8', 'sort_order' => 3],
            ['slug' => 'diri-sendiri', 'label' => 'Diri sendiri', 'color' => '#D8637F', 'sort_order' => 4],
            ['slug' => 'lainnya',      'label' => 'Lainnya',      'color' => '#A8B0C0', 'sort_order' => 5],
        ], 'slug');
    }

    private function patterns(): void
    {
        $this->put('patterns', [
            [
                'slug' => 'beban-tugas', 'title' => 'Beban tugas', 'icon' => 'clipboard-list', 'color' => '#E8637F', 'sort_order' => 1,
                'description' => 'Tugas yang menumpuk bikin otak susah menentukan mana yang harus dikerjakan duluan.',
                'now_action' => 'Pilih 1 tugas yang paling mendesak.',
                'can_wait' => 'Tugas dengan deadline minggu depan.',
                'watch_note' => 'Kalau tugas terus menumpuk, rasa kewalahan bisa makin besar.',
            ],
            [
                'slug' => 'tekanan-deadline', 'title' => 'Tekanan deadline', 'icon' => 'clock', 'color' => '#F0A04B', 'sort_order' => 2,
                'description' => 'Deadline yang terasa dekat membuat tubuh dan pikiran terus siaga.',
                'now_action' => 'Tulis tanggal pengumpulan dan bagi jadi dua tahap.',
                'can_wait' => 'Menyempurnakan hasil sebelum versi kasarnya ada.',
                'watch_note' => 'Menunda karena takut hasilnya jelek biasanya malah menambah tekanan.',
            ],
            [
                'slug' => 'energi-rendah', 'title' => 'Energi yang lagi rendah', 'icon' => 'battery-low', 'color' => '#6E7BE8', 'sort_order' => 3,
                'description' => 'Tubuh dan pikiran sedang kekurangan tenaga, jadi hal kecil terasa lebih berat.',
                'now_action' => 'Istirahat 10 menit, minum air, dan lepas dari layar.',
                'can_wait' => 'Tugas yang butuh konsentrasi penuh.',
                'watch_note' => 'Tidur yang kurang dan rasa hambar yang berlangsung lama perlu diperhatikan.',
            ],
            [
                'slug' => 'pikiran-ramai', 'title' => 'Pikiran yang ramai', 'icon' => 'brain', 'color' => '#5B9BE8', 'sort_order' => 4,
                'description' => 'Pikiran berputar pada hal yang sama dan sulit dimatikan, apalagi menjelang tidur.',
                'now_action' => 'Tulis semua yang kepikiran dalam 3 menit, tanpa disusun.',
                'can_wait' => 'Mencari jawaban untuk semua kekhawatiran sekaligus.',
                'watch_note' => 'Kalau cemasnya sering muncul tanpa sebab jelas, catat kapan terjadinya.',
            ],
            [
                'slug' => 'butuh-ruang', 'title' => 'Butuh ruang sendiri', 'icon' => 'door-open', 'color' => '#9B6BD8', 'sort_order' => 5,
                'description' => 'Interaksi sosial terasa menguras tenaga, jadi kamu butuh waktu untuk mengisi ulang.',
                'now_action' => 'Beri dirimu waktu sendiri yang jelas batasnya, misalnya 30 menit.',
                'can_wait' => 'Membalas semua pesan hari ini juga.',
                'watch_note' => 'Menyendiri berhari-hari tanpa mau bicara dengan siapa pun perlu diperhatikan.',
            ],
            [
                'slug' => 'emosi-sensitif', 'title' => 'Emosi lebih sensitif', 'icon' => 'zap', 'color' => '#D8637F', 'sort_order' => 6,
                'description' => 'Saat capek dan tertekan, hal kecil gampang memicu kesal. Itu respons yang wajar.',
                'now_action' => 'Tarik napas pelan 5 kali sebelum membalas atau memutuskan sesuatu.',
                'can_wait' => 'Membahas masalah dengan orang lain saat emosi sedang naik.',
                'watch_note' => 'Kalau kesal terus berulang dengan orang yang sama, pikirkan untuk membicarakannya nanti.',
            ],
        ], 'slug');
    }

    private function signals(): void
    {
        $p = $this->ids('patterns');

        $rows = [
            ['banyak-tugas',     'Ada banyak tugas yang harus diselesaikan',          'beban-tugas'],
            ['deadline-dekat',   'Deadline terasa semakin dekat',                     'tekanan-deadline'],
            ['sulit-fokus',      'Sulit fokus, gampang terdistraksi',                 'pikiran-ramai'],
            ['lelah-fisik',      'Merasa lelah secara fisik maupun mental',           'energi-rendah'],
            ['masalah-teman',    'Ada masalah dengan teman/kelompok',                 'emosi-sensitif'],
            ['cemas-tanpa-alasan', 'Sering merasa cemas tanpa alasan yang jelas',     'pikiran-ramai'],
            ['sulit-tidur',      'Tidur terasa kurang nyenyak',                       'energi-rendah'],
            ['overthinking',     'Pikiran berputar-putar soal hal yang sama',         'pikiran-ramai'],
            ['menarik-diri',     'Lebih ingin menyendiri dan malas bertemu orang',    'butuh-ruang'],
            ['cepat-kesal',      'Gampang kesal sama hal-hal kecil',                  'emosi-sensitif'],
            ['menunda',          'Menunda-nunda padahal tahu itu penting',            'beban-tugas'],
            ['target-tinggi',    'Takut hasilnya jelek atau merasa harus sempurna',   'tekanan-deadline'],
            ['tidak-semangat',   'Hal yang biasanya menyenangkan terasa hambar',      'energi-rendah'],
            ['tidak-bisa-jelaskan', 'Rasanya nggak enak tapi susah dijelaskan',       'pikiran-ramai'],
        ];

        $data = array_map(fn ($r) => [
            'slug' => $r[0], 'label' => $r[1], 'pattern_id' => $p[$r[2]], 'weight' => 1, 'is_red_flag' => false,
        ], $rows);

        // Sinyal keselamatan: tidak masuk skor pola, hanya memicu tampilan Mode Bantuan.
        $data[] = [
            'slug' => 'pikiran-menyakiti-diri',
            'label' => 'Muncul pikiran untuk menyakiti diri sendiri atau merasa nggak ingin melanjutkan',
            'pattern_id' => null, 'weight' => 0, 'is_red_flag' => true,
        ];

        $this->put('signals', $data, 'slug');
    }

    private function conditions(): void
    {
        $this->put('conditions', [
            ['slug' => 'capek-tanpa-sebab',     'title' => 'Aku capek, tapi nggak tahu kenapa', 'icon' => 'battery-low',  'color' => '#8B7FE8', 'sort_order' => 1, 'is_active' => true,
                'description' => 'Tubuh terasa berat padahal nggak ada kegiatan yang jelas menguras tenaga.'],
            ['slug' => 'pikiran-nggak-berhenti', 'title' => 'Kepalaku nggak berhenti mikir',    'icon' => 'brain',        'color' => '#5B9BE8', 'sort_order' => 2, 'is_active' => true,
                'description' => 'Pikiran terus berputar, susah dimatikan.'],
            ['slug' => 'kewalahan-tugas',        'title' => 'Tugas bikin aku kewalahan',        'icon' => 'clipboard-list', 'color' => '#E8637F', 'sort_order' => 3, 'is_active' => true,
                'description' => 'Terlalu banyak yang harus dikerjakan dan bingung mulai dari mana.'],
            ['slug' => 'pengen-sendiri',         'title' => 'Aku pengen sendiri terus',         'icon' => 'door-open',    'color' => '#9B6BD8', 'sort_order' => 4, 'is_active' => true,
                'description' => 'Bertemu orang terasa melelahkan akhir-akhir ini.'],
            ['slug' => 'gampang-kesal',          'title' => 'Aku gampang kesal akhir-akhir ini', 'icon' => 'flame',       'color' => '#F0A04B', 'sort_order' => 5, 'is_active' => true,
                'description' => 'Hal kecil gampang memicu emosi.'],
            ['slug' => 'nggak-enak',             'title' => 'Aku cuma merasa "nggak enak"',     'icon' => 'cloud',        'color' => '#6E7BE8', 'sort_order' => 6, 'is_active' => true,
                'description' => 'Ada yang terasa salah, tapi susah dijelaskan.'],
        ], 'slug');

        $c = $this->ids('conditions');
        $e = $this->ids('emotions');
        $s = $this->ids('signals');

        // Landing: chip perasaan -> kondisi
        $map = [
            'capek'   => ['capek-tanpa-sebab', 'kewalahan-tugas'],
            'cemas'   => ['pikiran-nggak-berhenti', 'nggak-enak'],
            'kesal'   => ['gampang-kesal'],
            'sedih'   => ['pengen-sendiri', 'nggak-enak'],
            'bingung' => ['nggak-enak', 'capek-tanpa-sebab'],
        ];
        $pivot = [];
        foreach ($map as $emotion => $conditions) {
            foreach ($conditions as $cond) {
                $pivot[] = ['condition_id' => $c[$cond], 'emotion_id' => $e[$emotion]];
            }
        }
        $this->put('condition_emotion', $pivot, ['condition_id', 'emotion_id'], false);

        // Asesmen: sinyal per kondisi (urutan = urutan tampil). Sinyal keselamatan selalu terakhir.
        $signals = [
            'capek-tanpa-sebab'      => ['banyak-tugas', 'deadline-dekat', 'sulit-fokus', 'lelah-fisik', 'masalah-teman', 'cemas-tanpa-alasan'],
            'pikiran-nggak-berhenti' => ['overthinking', 'cemas-tanpa-alasan', 'sulit-fokus', 'sulit-tidur', 'target-tinggi', 'deadline-dekat'],
            'kewalahan-tugas'        => ['banyak-tugas', 'deadline-dekat', 'menunda', 'target-tinggi', 'sulit-fokus', 'lelah-fisik'],
            'pengen-sendiri'         => ['menarik-diri', 'masalah-teman', 'lelah-fisik', 'tidak-semangat', 'overthinking', 'cemas-tanpa-alasan'],
            'gampang-kesal'          => ['cepat-kesal', 'masalah-teman', 'sulit-tidur', 'banyak-tugas', 'lelah-fisik', 'deadline-dekat'],
            'nggak-enak'             => ['tidak-bisa-jelaskan', 'cemas-tanpa-alasan', 'lelah-fisik', 'tidak-semangat', 'menarik-diri', 'overthinking'],
        ];
        $rows = [];
        foreach ($signals as $cond => $list) {
            foreach ($list as $i => $sig) {
                $rows[] = ['condition_id' => $c[$cond], 'signal_id' => $s[$sig], 'sort_order' => $i + 1];
            }
            $rows[] = ['condition_id' => $c[$cond], 'signal_id' => $s['pikiran-menyakiti-diri'], 'sort_order' => 99];
        }
        $this->put('condition_signal', $rows, ['condition_id', 'signal_id'], false);
    }
}
