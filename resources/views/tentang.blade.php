@extends('layouts.main')

@section('title')
    <title>Tentang | {{ config('app.name') }}</title>
@endsection

@section('container')
@php
    $values = [
        ['judul' => 'Personal',        'isi' => 'Sesuai dengan kondisi dan kebutuhanmu.',          'ikon' => 'bx-user',         'warna' => 'bg-violet-100 text-violet-700'],
        ['judul' => 'Aman',            'isi' => 'Datamu tetap di perangkatmu, tanpa akun.',        'ikon' => 'bx-shield-alt-2', 'warna' => 'bg-sky-100 text-sky-700'],
        ['judul' => 'Mudah diakses',   'isi' => 'Kapan saja, di mana saja, lewat ponsel.',         'ikon' => 'bx-mobile-alt',   'warna' => 'bg-emerald-100 text-emerald-700'],
    ];
    $privacy = [
        ['judul' => 'Tanpa akun',               'isi' => 'Kamu tidak perlu mendaftar atau login untuk memakai Mindway.',                                                         'ikon' => 'bx-user-x'],
        ['judul' => 'Tersimpan di browser',     'isi' => 'Jawaban dan hasilmu diproses di perangkat ini. Hanya 5 asesmen terakhir yang disimpan selama 30 hari, lalu terhapus otomatis.', 'ikon' => 'bx-lock-alt'],
        ['judul' => 'Kamu yang pegang kendali', 'isi' => 'Download riwayatmu sebagai PDF atau hapus kapan saja dari halaman Riwayat.',                                           'ikon' => 'bx-file'],
    ];
@endphp

<div class="relative min-h-[calc(100vh-4rem)] overflow-hidden">
@include('partials.dekor.gaya')
@include('partials.dekor.tentang')

<main class="relative z-10 mx-auto max-w-6xl px-4 py-10 sm:px-6 sm:py-14">

    <section class="mw-rise grid items-center gap-8 lg:grid-cols-5 lg:gap-12">
        <div class="lg:col-span-3">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1 text-xs font-bold text-indigo-700 shadow-sm ring-1 ring-indigo-100">
                <i class='bx bx-leaf'></i> Tentang Mindway
            </span>
            <h1 class="mt-4 text-4xl leading-tight font-extrabold tracking-tight text-indigo-950 sm:text-5xl">
                Bukan cuma tempat curhat, tapi peta untuk menemukan jalanmu sendiri.
            </h1>
            <p class="mt-5 max-w-xl text-base leading-relaxed text-slate-600">
                Mindway hadir untuk menemani kamu di setiap titik sulit yang mungkin kamu alami. Kami percaya, setiap orang punya cara sendiri untuk merasa baik, dan kamu tidak harus melakukannya sendirian.
            </p>
            <p class="mt-3 max-w-xl text-base leading-relaxed text-slate-600">
                Kamu nggak harus tahu kamu kenapa. Mulai dari apa yang kamu rasakan, lalu kita susun petanya pelan-pelan.
            </p>
            <div class="mt-7 flex flex-wrap items-center gap-4">
                <a href="{{ url('/asesmen') }}"
                   class="inline-flex h-12 items-center gap-2 rounded-full bg-linear-to-r from-indigo-950 to-indigo-700 px-7 text-sm font-bold text-white shadow-lg shadow-indigo-900/25 transition hover:from-indigo-900 hover:to-indigo-600 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
                    Mulai Asesmen <i class='bx bx-right-arrow-alt text-xl'></i>
                </a>
                <a href="{{ url('/') }}#cara-kerja" class="text-sm font-bold text-indigo-800 hover:underline">Lihat cara kerjanya</a>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="relative overflow-hidden rounded-4xl bg-linear-to-br from-indigo-50 via-white to-violet-50 p-6 text-center shadow-xl shadow-indigo-100/60 ring-1 ring-slate-100 sm:p-8">
                <img src="{{ asset('img/ruang-tenang.svg') }}" alt="" class="mw-float mx-auto h-52 w-auto" decoding="async">
                <p class="mt-3 text-sm leading-relaxed font-bold text-indigo-950">Kamu nggak harus tahu kamu kenapa.</p>
                <p class="text-sm leading-relaxed text-slate-600">Mulai dari apa yang kamu rasakan.</p>
            </div>
        </div>
    </section>

    <section class="mt-14" aria-labelledby="judul-nilai">
        <h2 id="judul-nilai" class="sr-only">Nilai Mindway</h2>
        <ul class="grid gap-4 sm:grid-cols-3">
            @foreach ($values as $v)
                <li class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100 transition hover:-translate-y-1 hover:shadow-lg hover:shadow-indigo-100">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl text-2xl {{ $v['warna'] }}">
                        <i class='bx {{ $v['ikon'] }}'></i>
                    </span>
                    <h3 class="mt-4 text-lg font-extrabold text-indigo-950">{{ $v['judul'] }}</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-slate-600">{{ $v['isi'] }}</p>
                </li>
            @endforeach
        </ul>
    </section>

    <section class="mt-14 overflow-hidden rounded-4xl bg-indigo-950 p-7 text-white shadow-xl shadow-indigo-900/20 sm:p-10" aria-labelledby="judul-inovasi">
        <div class="grid items-center gap-6 md:grid-cols-5">
            <div class="md:col-span-3">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-300 text-2xl text-indigo-950"><i class='bx bx-bulb'></i></span>
                <h2 id="judul-inovasi" class="mt-4 text-2xl font-extrabold tracking-tight sm:text-3xl">Kenapa Mindway?</h2>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-indigo-100 sm:text-base">
                    Mindway bukan sekadar website kesehatan mental, tapi alat situasional yang membantu mahasiswa menemukan apa yang sebenarnya mereka butuhkan, saat merasa kewalahan.
                </p>
            </div>
            <p class="rounded-3xl bg-white/10 p-6 text-lg leading-snug font-bold text-amber-200 ring-1 ring-white/15 md:col-span-2">&ldquo;Satu langkah kecil bisa jadi awal dari perubahan besar.&rdquo;</p>
        </div>
    </section>

    <section class="mt-14" aria-labelledby="judul-privasi">
        <div class="max-w-xl">
            <h2 id="judul-privasi" class="text-2xl font-extrabold tracking-tight text-indigo-950 sm:text-3xl">Bagaimana Mindway menjaga privasimu</h2>
            <p class="mt-2 text-slate-600">Cerita tentang perasaanmu itu pribadi, jadi kami merancangnya supaya tetap di tanganmu.</p>
        </div>
        <ul class="mt-6 grid gap-4 md:grid-cols-3">
            @foreach ($privacy as $p)
                <li class="rounded-3xl bg-white/90 p-6 ring-1 ring-slate-100">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-100 text-2xl text-indigo-700"><i class='bx {{ $p['ikon'] }}'></i></span>
                    <h3 class="mt-4 font-bold text-indigo-950">{{ $p['judul'] }}</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-slate-600">{{ $p['isi'] }}</p>
                </li>
            @endforeach
        </ul>
    </section>

    <section class="mt-14 rounded-3xl bg-amber-50 p-6 ring-1 ring-amber-200 sm:p-8" aria-labelledby="judul-batas">
        <h2 id="judul-batas" class="flex items-center gap-2 text-lg font-extrabold text-amber-900">
            <i class='bx bx-info-circle text-2xl'></i> Yang perlu kamu tahu
        </h2>
        <p class="mt-3 text-sm leading-relaxed text-amber-900 sm:text-base">
            Mindway adalah alat bantu refleksi diri. Hasilnya adalah gambaran dari apa yang kamu pilih, bukan diagnosis, dan bukan pengganti psikolog, konselor, atau tenaga profesional lainnya. Kalau kamu merasa nggak aman atau ingin menyakiti diri sendiri, segera hubungi layanan darurat atau orang yang kamu percaya di dekatmu.
        </p>
    </section>

    <section class="mt-14 text-center">
        <h2 class="text-2xl font-extrabold tracking-tight text-indigo-950 sm:text-3xl">Siap mulai dari yang kamu rasakan?</h2>
        <div class="mt-6 flex flex-col items-center justify-center gap-3 sm:flex-row">
            <a href="{{ url('/asesmen') }}"
               class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-full bg-linear-to-r from-indigo-950 to-indigo-700 px-8 text-sm font-bold text-white shadow-lg shadow-indigo-900/25 transition hover:from-indigo-900 hover:to-indigo-600 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 sm:w-auto">
                Mulai Asesmen <i class='bx bx-right-arrow-alt text-xl'></i>
            </a>
            <a href="{{ url('/riwayat') }}"
               class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-full border border-slate-300 bg-white px-8 text-sm font-bold text-slate-700 transition hover:bg-slate-50 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 sm:w-auto">
                <i class='bx bx-history text-lg'></i> Lihat riwayatku
            </a>
        </div>
    </section>
</main>
</div>
@endsection
