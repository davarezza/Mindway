<?php

namespace Database\Seeders;

/**
 * Daftar bantuan (Mode Bantuan) dan teks situs (landing, tentang, keunggulan, disclaimer).
 */
class SupportSeeder extends BaseContentSeeder
{
    public function run(): void
    {
        // PENTING: is_verified = false berarti kontak ini belum dicek tim.
        // Verifikasi nomor, jam layanan, dan URL sebelum rilis, lalu ubah jadi true.
        $this->put('support_resources', [
            [
                'slug' => 'darurat-112', 'name' => 'Layanan darurat 112', 'category' => 'darurat',
                'description' => 'Untuk situasi yang membahayakan nyawa atau keselamatanmu saat ini.',
                'phone' => '112', 'url' => null, 'availability' => '24 jam', 'is_verified' => false, 'is_active' => true, 'sort_order' => 1,
            ],
            [
                'slug' => 'kemenkes-119-ext-8', 'name' => 'Layanan kesehatan jiwa Kemenkes (119 ext. 8)', 'category' => 'hotline',
                'description' => 'Layanan konsultasi kesehatan jiwa lewat telepon. Cek ulang nomor dan jam layanannya sebelum rilis.',
                'phone' => '119 ext. 8', 'url' => null, 'availability' => 'Perlu diverifikasi', 'is_verified' => false, 'is_active' => true, 'sort_order' => 2,
            ],
            [
                'slug' => 'konseling-kampus', 'name' => 'Layanan konseling kampus', 'category' => 'kampus',
                'description' => 'Banyak kampus punya unit konseling untuk mahasiswa. Isi kontak kampusmu di sini.',
                'phone' => null, 'url' => null, 'availability' => 'Sesuai jam kampus', 'is_verified' => false, 'is_active' => true, 'sort_order' => 3,
            ],
            [
                'slug' => 'puskesmas-terdekat', 'name' => 'Puskesmas atau psikolog klinis terdekat', 'category' => 'profesional',
                'description' => 'Tempat yang bisa kamu datangi langsung untuk konsultasi awal.',
                'phone' => null, 'url' => null, 'availability' => 'Sesuai jam layanan', 'is_verified' => false, 'is_active' => true, 'sort_order' => 4,
            ],
            [
                'slug' => 'into-the-light', 'name' => 'Into The Light Indonesia', 'category' => 'komunitas',
                'description' => 'Komunitas yang fokus pada pencegahan bunuh diri dan kesehatan jiwa. Cek ulang URL dan layanannya sebelum rilis.',
                'phone' => null, 'url' => 'https://www.intothelightid.org', 'availability' => null, 'is_verified' => false, 'is_active' => true, 'sort_order' => 5,
            ],
        ], 'slug');

        $content = [
            'brand' => [
                'name' => 'Mindway',
                'tagline' => 'Bukan cuma tempat curhat, tapi peta untuk menemukan jalanmu sendiri.',
                'highlight' => ['title' => 'Kamu nggak harus tahu kamu kenapa.', 'body' => 'Mulai dari apa yang kamu rasakan.'],
            ],
            'landing.hero' => [
                'headline' => 'Coba kita cek, sebenarnya yang bikin kamu capek apa?',
                'subtext' => 'Nggak perlu cerita panjang. Pilih yang paling mirip sama keadaanmu.',
                'cta_label' => 'Mulai Sekarang',
                'emotions_label' => 'Kamu bisa merasa:',
            ],
            'landing.advantages' => [
                ['title' => 'Personal & kontekstual', 'body' => 'Menyesuaikan dengan alasan nyata yang sedang kamu alami.', 'icon' => 'user'],
                ['title' => 'Bukan sekadar informatif', 'body' => 'Langsung memberi satu langkah kecil yang bisa kamu lakukan.', 'icon' => 'zap'],
                ['title' => 'Ada riwayat dan pola', 'body' => 'Membantu kamu melihat pola dari waktu ke waktu.', 'icon' => 'bar-chart'],
                ['title' => 'Ringan dan mudah diakses', 'body' => 'Bisa dipakai kapan saja lewat ponsel, tanpa perlu akun.', 'icon' => 'smartphone'],
            ],
            'landing.innovation' => [
                'title' => 'Nilai Inovasi',
                'body' => 'Mindway bukan sekadar website kesehatan mental, tapi sebuah alat situasional yang membantu mahasiswa menemukan apa yang sebenarnya mereka butuhkan, saat mereka belum membutuhkan terapi.',
                'closing' => 'Satu langkah kecil bisa jadi awal dari perubahan besar.',
            ],
            'about.page' => [
                'title' => 'Tentang Mindway',
                'body' => 'Mindway hadir untuk menemani kamu di setiap titik sulit yang mungkin kamu alami. Kami percaya, setiap orang punya cara sendiri untuk merasa baik, dan kamu tidak harus melakukannya sendirian.',
                'values' => [
                    ['title' => 'Personal', 'body' => 'Sesuai dengan kondisi dan kebutuhanmu.', 'icon' => 'user'],
                    ['title' => 'Aman', 'body' => 'Data kamu terlindungi.', 'icon' => 'shield'],
                    ['title' => 'Mudah Diakses', 'body' => 'Kapan saja, di mana saja.', 'icon' => 'smartphone'],
                ],
            ],
            'result.footer' => ['body' => 'Makanya semuanya terasa lebih berat daripada biasanya.'],
            'privacy.note' => [
                'body' => 'Kamu bisa memakai Mindway tanpa akun. Riwayatmu tersimpan di perangkat ini dan bisa dihapus kapan saja.',
            ],
            'site.disclaimer' => [
                'body' => 'Mindway adalah alat bantu refleksi diri, bukan alat diagnosis dan bukan pengganti tenaga profesional. Kalau kamu merasa nggak aman, segera hubungi layanan darurat atau profesional.',
            ],
        ];

        $rows = [];
        foreach ($content as $key => $value) {
            $rows[] = ['key' => $key, 'value' => json_encode($value, JSON_UNESCAPED_UNICODE)];
        }
        $this->put('site_contents', $rows, 'key');
    }
}
