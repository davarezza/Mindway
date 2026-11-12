@extends('layouts.main')

@section('title')
    <title>Home | {{ config('app.name') }}</title>
@endsection

@section('container')
@php
    $emotions = [
        ['slug' => 'capek',   'label' => 'Capek',   'ikon' => 'bx-battery',     'warna' => '#8B7FE8'],
        ['slug' => 'cemas',   'label' => 'Cemas',   'ikon' => 'bx-wind',        'warna' => '#5B9BE8'],
        ['slug' => 'kesal',   'label' => 'Kesal',   'ikon' => 'bxs-hot',        'warna' => '#F0A04B'],
        ['slug' => 'sedih',   'label' => 'Sedih',   'ikon' => 'bx-cloud-rain',  'warna' => '#4C63C9'],
        ['slug' => 'bingung', 'label' => 'Bingung', 'ikon' => 'bx-help-circle', 'warna' => '#6E8BE8'],
    ];
    $steps = [
        ['judul' => 'Pilih kondisi',        'isi' => 'Pilih yang paling mirip dengan keadaanmu saat ini.',          'ikon' => 'bx-pointer',      'warna' => 'bg-sky-100 text-sky-700'],
        ['judul' => 'Jawab singkat',        'isi' => 'Centang hal-hal yang sering terjadi belakangan ini.',         'ikon' => 'bx-list-check',   'warna' => 'bg-violet-100 text-violet-700'],
        ['judul' => 'Lihat hasilnya',       'isi' => 'Lihat hal yang paling sering muncul bersamaan.',              'ikon' => 'bx-search-alt',   'warna' => 'bg-amber-100 text-amber-700'],
        ['judul' => 'Mulai langkah kecil',  'isi' => 'Dapat satu langkah kecil yang bisa langsung kamu lakukan.',   'ikon' => 'bx-target-lock',  'warna' => 'bg-rose-100 text-rose-700'],
        ['judul' => 'Pantau di My Map',     'isi' => 'Lihat pola dari catatanmu dari waktu ke waktu.',              'ikon' => 'bx-line-chart',   'warna' => 'bg-emerald-100 text-emerald-700'],
    ];
    $advantages = [
        ['judul' => 'Personal & kontekstual',   'isi' => 'Menyesuaikan dengan alasan nyata yang sedang kamu alami.',        'ikon' => 'bx-user'],
        ['judul' => 'Bukan sekadar informatif', 'isi' => 'Langsung memberi satu langkah kecil yang bisa kamu lakukan.',     'ikon' => 'bx-bolt-circle'],
        ['judul' => 'Ada riwayat dan pola',     'isi' => 'Membantu kamu melihat pola dari waktu ke waktu.',                 'ikon' => 'bx-bar-chart-alt-2'],
        ['judul' => 'Ringan dan mudah diakses', 'isi' => 'Bisa dipakai kapan saja lewat ponsel, tanpa perlu akun.',         'ikon' => 'bx-mobile-alt'],
    ];
@endphp

<main class="relative overflow-hidden">
    <div class="pointer-events-none absolute -top-24 -left-24 h-72 w-72 rounded-full bg-violet-200/50 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute top-40 -right-24 h-80 w-80 rounded-full bg-sky-200/50 blur-3xl" aria-hidden="true"></div>

    {{-- HERO --}}
    <section class="relative mx-auto grid max-w-6xl items-center gap-10 px-4 pt-10 pb-16 sm:px-6 lg:grid-cols-2 lg:gap-12 lg:pt-4 lg:pb-8">
        <div>
            <h1 class="mt-5 text-4xl leading-tight font-extrabold tracking-tight text-indigo-950 sm:text-5xl">
                Coba kita cek, sebenarnya yang bikin kamu capek apa?
            </h1>
            <p class="mt-4 max-w-md text-base leading-relaxed text-slate-600">
                Nggak perlu cerita panjang. Pilih yang paling mirip sama keadaanmu.
            </p>

            <div class="mt-7 flex flex-wrap items-center gap-4">
                <a href="{{ url('/asesmen') }}"
                   class="inline-flex items-center gap-2 rounded-full bg-indigo-950 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
                    Mulai Sekarang
                    <i class='bx bx-right-arrow-alt text-xl'></i>
                </a>
                <a href="#cara-kerja" class="text-sm font-bold text-indigo-800 hover:underline">
                    Lihat cara kerjanya
                </a>
                <a href="{{ url('/riwayat') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-800 hover:underline">
                    <i class='bx bx-history text-lg'></i> Peta &amp; riwayatku
                </a>
            </div>

            <ul class="mt-5 flex flex-wrap gap-x-5 gap-y-1 text-xs font-medium text-slate-500">
                <li class="flex items-center gap-1.5"><i class='bx bx-check-circle text-emerald-600'></i> Tanpa perlu akun</li>
                <li class="flex items-center gap-1.5"><i class='bx bx-check-circle text-emerald-600'></i> Riwayat tersimpan di perangkatmu</li>
            </ul>

            <div class="mt-8 rounded-3xl bg-white p-5 shadow-xl shadow-indigo-100/60 ring-1 ring-slate-100">
                <p class="text-xs font-bold text-slate-500">Kamu bisa merasa:</p>
                <ul class="mt-3 grid grid-cols-3 gap-3 sm:grid-cols-5">
                    @foreach ($emotions as $emotion)
                        <li>
                            <a href="{{ url('/asesmen') }}?emosi={{ $emotion['slug'] }}"
                               class="group flex flex-col items-center gap-2 rounded-2xl border border-slate-100 bg-slate-50/60 px-2 py-3 transition hover:-translate-y-0.5 hover:border-indigo-200 hover:bg-white hover:shadow-md focus-visible:ring-2 focus-visible:ring-indigo-400">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full text-xl"
                                      style="background-color: {{ $emotion['warna'] }}22; color: {{ $emotion['warna'] }}">
                                    <i class='bx {{ $emotion['ikon'] }}'></i>
                                </span>
                                <span class="text-xs font-bold text-slate-700">{{ $emotion['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-md lg:max-w-none">
            <img src="{{ asset('img/student-stress.svg') }}"
                 alt="Ilustrasi mahasiswa yang sedang merasa tertekan"
                 class="mx-auto h-auto max-h-144 w-full object-contain"
                 decoding="async">
        </div>
    </section>

    {{-- CARA KERJA --}}
    <section id="cara-kerja" class="relative mx-auto max-w-6xl scroll-mt-20 px-4 pb-16 sm:px-6 lg:pb-24">
        <div class="max-w-xl">
            <h2 class="text-2xl font-extrabold tracking-tight text-indigo-950 sm:text-3xl">Cara kerjanya sederhana</h2>
            <p class="mt-2 text-slate-600">Lima langkah ringan, dari bingung sampai punya peta kecil untuk dirimu sendiri.</p>
        </div>

        <ol class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($steps as $i => $step)
                <li class="relative rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl text-2xl {{ $step['warna'] }}">
                        <i class='bx {{ $step['ikon'] }}'></i>
                    </span>
                    <p class="mt-4 text-xs font-bold text-slate-400">Langkah {{ $i + 1 }}</p>
                    <h3 class="mt-0.5 font-bold text-indigo-950">{{ $step['judul'] }}</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-slate-600">{{ $step['isi'] }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- KEUNGGULAN --}}
    <section id="fitur" class="relative mx-auto max-w-6xl scroll-mt-20 px-4 pb-16 sm:px-6 lg:pb-24">
        <div class="rounded-4xl bg-indigo-50 p-6 sm:p-10">
            <h2 class="text-2xl font-extrabold tracking-tight text-indigo-950 sm:text-3xl">Kenapa Mindway?</h2>

            <ul class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($advantages as $item)
                    <li class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-indigo-100">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-100 text-2xl text-indigo-700">
                            <i class='bx {{ $item['ikon'] }}'></i>
                        </span>
                        <h3 class="mt-4 font-bold text-indigo-950">{{ $item['judul'] }}</h3>
                        <p class="mt-1.5 text-sm leading-relaxed text-slate-600">{{ $item['isi'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- CTA AKHIR --}}
    <section class="relative mx-auto max-w-3xl px-4 pb-16 text-center sm:px-6 lg:pb-20">
        <h2 class="text-2xl font-extrabold tracking-tight text-indigo-950 sm:text-3xl">Siap mulai dari yang kamu rasakan?</h2>
        <p class="mx-auto mt-3 max-w-md text-slate-600">
            Kamu bisa memakai Mindway tanpa akun. Riwayatmu tersimpan di perangkat ini dan bisa dihapus kapan saja.
        </p>
        <a href="{{ url('/asesmen') }}"
           class="mt-6 inline-flex items-center gap-2 rounded-full bg-indigo-950 px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
            Mulai Sekarang
            <i class='bx bx-right-arrow-alt text-xl'></i>
        </a>

        <p class="mx-auto mt-12 flex max-w-xl items-start justify-center gap-2 text-xs leading-relaxed text-slate-500">
            <i class='bx bx-info-circle mt-0.5 text-base'></i>
            <span>Mindway adalah alat bantu refleksi diri, bukan alat diagnosis dan bukan pengganti tenaga profesional. Kalau kamu merasa nggak aman, segera hubungi layanan darurat atau profesional.</span>
        </p>
    </section>
</main>
@endsection
