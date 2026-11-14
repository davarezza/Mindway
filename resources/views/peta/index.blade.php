@extends('layouts.main')

@section('title')
    <title>Peta Kondisiku | {{ config('app.name') }}</title>
@endsection

@section('container')
<div class="relative overflow-hidden">
<div id="dekor" hidden class="pointer-events-none absolute inset-0 z-0" aria-hidden="true">
    <span class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-indigo-100/80 blur-2xl"></span>
    <span class="absolute -left-28 top-[28rem] h-72 w-72 rounded-full bg-emerald-100/70 blur-2xl"></span>
    <span class="absolute -right-20 top-[46rem] h-56 w-56 rounded-full bg-violet-100/70 blur-2xl"></span>
    <div class="absolute -left-4 top-28 hidden h-[24rem] w-32 xl:block">
        <svg viewBox="0 0 120 360" class="h-full w-full" fill="none" aria-hidden="true">
            <path d="M60 360C58 280 68 200 52 120S56 30 60 0" stroke="#A5B4FC" stroke-width="3" stroke-linecap="round"/>
            <ellipse cx="38" cy="300" rx="26" ry="11" transform="rotate(-35 38 300)" fill="#C7D2FE" fill-opacity=".8"/>
            <ellipse cx="82" cy="262" rx="26" ry="11" transform="rotate(35 82 262)" fill="#A7F3D0" fill-opacity=".8"/>
            <ellipse cx="36" cy="214" rx="24" ry="10" transform="rotate(-35 36 214)" fill="#DDD6FE" fill-opacity=".85"/>
            <ellipse cx="78" cy="170" rx="24" ry="10" transform="rotate(35 78 170)" fill="#C7D2FE" fill-opacity=".8"/>
            <ellipse cx="34" cy="124" rx="22" ry="9" transform="rotate(-35 34 124)" fill="#A7F3D0" fill-opacity=".8"/>
            <ellipse cx="74" cy="80" rx="20" ry="8" transform="rotate(35 74 80)" fill="#DDD6FE" fill-opacity=".85"/>
            <ellipse cx="58" cy="28" rx="14" ry="7" transform="rotate(-70 58 28)" fill="#C7D2FE" fill-opacity=".8"/>
        </svg>
    </div>
    <div class="absolute -right-4 top-72 hidden h-[24rem] w-32 -scale-x-100 xl:block">
        <svg viewBox="0 0 120 360" class="h-full w-full" fill="none" aria-hidden="true">
            <path d="M60 360C58 280 68 200 52 120S56 30 60 0" stroke="#A5B4FC" stroke-width="3" stroke-linecap="round"/>
            <ellipse cx="38" cy="300" rx="26" ry="11" transform="rotate(-35 38 300)" fill="#C7D2FE" fill-opacity=".8"/>
            <ellipse cx="82" cy="262" rx="26" ry="11" transform="rotate(35 82 262)" fill="#A7F3D0" fill-opacity=".8"/>
            <ellipse cx="36" cy="214" rx="24" ry="10" transform="rotate(-35 36 214)" fill="#DDD6FE" fill-opacity=".85"/>
            <ellipse cx="78" cy="170" rx="24" ry="10" transform="rotate(35 78 170)" fill="#C7D2FE" fill-opacity=".8"/>
            <ellipse cx="34" cy="124" rx="22" ry="9" transform="rotate(-35 34 124)" fill="#A7F3D0" fill-opacity=".8"/>
            <ellipse cx="74" cy="80" rx="20" ry="8" transform="rotate(35 74 80)" fill="#DDD6FE" fill-opacity=".85"/>
            <ellipse cx="58" cy="28" rx="14" ry="7" transform="rotate(-70 58 28)" fill="#C7D2FE" fill-opacity=".8"/>
        </svg>
    </div>
</div>
<main class="relative z-10 mx-auto max-w-3xl px-4 py-8 sm:px-6 sm:py-12">

    {{-- Progres hanya tampil di layar pertanyaan (1/3) dan langkah (2/3). Layar ke-3 adalah Ruang Tenang. --}}
    <div id="progress" hidden class="mb-8 flex items-center gap-4">
        <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-slate-200"
             role="progressbar" aria-label="Progres" aria-valuemin="1" aria-valuemax="3" aria-valuenow="1" id="progress-track">
            <div id="progress-bar" class="h-full rounded-full bg-indigo-950 transition-all duration-300" style="width: 33.33%"></div>
        </div>
        <span id="progress-counter" class="text-xs font-bold text-slate-500">1/3</span>
    </div>

    <noscript>
        <p class="rounded-2xl bg-amber-50 p-4 text-sm text-amber-900 ring-1 ring-amber-200">
            Halaman ini membutuhkan JavaScript untuk membaca hasilmu dari perangkat ini.
        </p>
    </noscript>

    {{-- Asesmen tidak ditemukan (kedaluwarsa, data browser dihapus, atau pindah perangkat) --}}
    <section id="state-kosong" hidden class="rounded-4xl bg-white p-8 text-center shadow-xl shadow-indigo-100/60 ring-1 ring-slate-100 sm:p-12">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-3xl text-slate-500">
            <i class='bx bx-error-circle'></i>
        </span>
        <h1 class="mt-5 text-2xl font-extrabold tracking-tight text-indigo-950">Petanya belum ada</h1>
        <p class="mx-auto mt-2 max-w-sm text-sm leading-relaxed text-slate-600">
            Peta dibuat dari hasil asesmen yang tersimpan di browser ini selama 30 hari. Mungkin sudah kedaluwarsa, datanya terhapus, atau kamu membuka dari perangkat lain.
        </p>
        <a href="{{ $payload['startUrl'] }}"
           class="mt-6 inline-flex h-12 items-center justify-center gap-2 rounded-full bg-indigo-950 px-8 text-sm font-bold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
            Mulai asesmen <i class='bx bx-right-arrow-alt text-xl'></i>
        </a>
    </section>

    {{-- ============ LAYAR 5: PETA KONDISIKU ============ --}}
    <section id="layar-peta" hidden class="lg:-mx-24">
        @include('partials.banner-bantuan', ['support' => $support])

        <div class="flex items-center gap-4">
            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-indigo-950 text-3xl text-white shadow-lg shadow-indigo-900/20">
                <i class='bx bx-map-alt'></i>
            </span>
            <div>
                <h1 tabindex="-1" class="text-3xl font-extrabold tracking-tight text-indigo-950 focus:outline-none">Peta Kondisiku</h1>
                <p class="mt-1 text-sm text-slate-600">Ini gambaran kondisi yang kamu alami saat ini.</p>
            </div>
        </div>

        <p class="mt-5 flex items-start gap-2 rounded-2xl bg-white/80 p-4 text-sm leading-relaxed text-slate-600 ring-1 ring-slate-100 backdrop-blur">
            <i class='bx bx-info-circle mt-0.5 text-lg text-indigo-500'></i>
            <span>Peta ini disusun dari jawabanmu. Bacalah sebagai gambaran supaya lebih mudah melihat apa yang terjadi dan apa yang bisa dilakukan pelan-pelan, <strong class="font-bold text-slate-800">bukan diagnosis</strong>.</span>
        </p>

        <p id="catatan-berat" hidden class="mt-4 flex items-start gap-2 rounded-2xl bg-indigo-50 p-4 text-sm leading-relaxed text-indigo-900 ring-1 ring-indigo-100">
            <i class='bx bx-heart mt-0.5 text-lg'></i>
            <span>Kalau masih terasa berat, nggak apa-apa. Kamu boleh pilih bantuan yang lain, atau cari dukungan.</span>
        </p>

        <div id="peta-kotak" class="mt-6 grid gap-4 sm:grid-cols-2">
            <div class="rounded-3xl bg-gradient-to-br from-rose-50 to-white p-5 sm:row-span-3 shadow-sm ring-1 ring-rose-100 sm:p-6">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-xl text-rose-600"><i class='bx bx-pulse'></i></span>
                    <div>
                        <h2 class="text-sm font-extrabold text-rose-700">Yang sedang terjadi</h2>
                        <p class="mt-0.5 text-xs leading-relaxed text-slate-500">Hal yang paling terasa dari jawabanmu.</p>
                    </div>
                </div>
                <ul id="peta-terjadi" class="mt-4 space-y-3 text-sm text-slate-700"></ul>
            </div>
            <div class="rounded-3xl bg-gradient-to-br from-emerald-50 to-white p-5 shadow-sm ring-1 ring-emerald-100 sm:p-6">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-xl text-emerald-600"><i class='bx bx-bulb'></i></span>
                    <div>
                        <h2 class="text-sm font-extrabold text-emerald-700">Yang bisa dilakukan sekarang</h2>
                        <p class="mt-0.5 text-xs leading-relaxed text-slate-500">Satu hal kecil yang masih terjangkau.</p>
                    </div>
                </div>
                <ul id="peta-sekarang" class="mt-4 space-y-2 text-sm text-slate-700"></ul>
            </div>
            <div class="rounded-3xl bg-gradient-to-br from-sky-50 to-white p-5 shadow-sm ring-1 ring-sky-100 sm:p-6">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-xl text-sky-600"><i class='bx bx-hourglass'></i></span>
                    <div>
                        <h2 class="text-sm font-extrabold text-sky-700">Yang tidak perlu diselesaikan sekarang</h2>
                        <p class="mt-0.5 text-xs leading-relaxed text-slate-500">Boleh ditunda, nggak harus beres hari ini.</p>
                    </div>
                </div>
                <ul id="peta-tunggu" class="mt-4 space-y-2 text-sm text-slate-700"></ul>
            </div>
            <div class="rounded-3xl bg-gradient-to-br from-violet-50 to-white p-5 shadow-sm ring-1 ring-violet-100 sm:p-6">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-100 text-xl text-violet-600"><i class='bx bx-show'></i></span>
                    <div>
                        <h2 class="text-sm font-extrabold text-violet-700">Yang perlu diperhatikan</h2>
                        <p class="mt-0.5 text-xs leading-relaxed text-slate-500">Sinyal yang baik dipantau pelan-pelan.</p>
                    </div>
                </div>
                <ul id="peta-perhatian" class="mt-4 space-y-2 text-sm text-slate-700"></ul>
            </div>
        </div>
        <p id="peta-kosong" hidden class="mt-6 rounded-2xl bg-white p-5 text-sm leading-relaxed text-slate-600 ring-1 ring-slate-100">
            Belum ada pola yang menonjol dari jawabanmu, jadi petanya belum bisa disusun. Kamu tetap bisa memilih bantuan di bawah.
        </p>

        <h2 class="mt-8 text-lg font-extrabold text-indigo-950">Kamu mau dibantu bagian mana dulu?</h2>
        <ul id="daftar-mode" class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4"></ul>
    </section>

    {{-- ============ LAYAR 6: PERTANYAAN MODE ============ --}}
    <section id="layar-pertanyaan" hidden>
        <h1 id="q-judul" tabindex="-1" class="text-3xl font-extrabold tracking-tight text-indigo-950 focus:outline-none"></h1>
        <p id="q-bantu" class="mt-2 text-sm text-slate-600"></p>

        <ul id="q-opsi" class="mt-6 space-y-3"></ul>

        <div class="mt-8 flex flex-col-reverse gap-3 min-[380px]:flex-row min-[380px]:items-start min-[380px]:justify-between">
            <button type="button" id="q-kembali"
                    class="inline-flex h-12 min-w-[9.5rem] items-center justify-center gap-2 rounded-full border border-slate-300 bg-white px-6 text-sm font-bold text-slate-700 transition hover:bg-slate-50 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
                <i class='bx bx-left-arrow-alt text-xl'></i> Kembali
            </button>
            <div class="flex flex-col items-stretch gap-1 min-[380px]:items-end">
                <button type="button" id="q-lanjut" disabled
                        class="inline-flex h-12 min-w-[9.5rem] items-center justify-center gap-2 rounded-full bg-indigo-950 px-6 text-sm font-bold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-40 disabled:shadow-none disabled:hover:bg-indigo-950">
                    Lanjut <i class='bx bx-right-arrow-alt text-xl'></i>
                </button>
                <p class="text-xs text-slate-500">Pilih satu</p>
            </div>
        </div>
    </section>

    {{-- ============ LAYAR 7: REKOMENDASI LANGKAH KECIL ============ --}}
    <section id="layar-langkah" hidden>
        <h1 id="l-judul" tabindex="-1" class="text-3xl font-extrabold tracking-tight text-indigo-950 focus:outline-none"></h1>
        <p id="l-intro" class="mt-2 text-sm text-slate-600"></p>

        <ol id="l-daftar" class="mt-6 space-y-3"></ol>

        {{-- Hanya tampil di mode Bantuan. Isinya kontak is_verified; kalau belum ada, teks umum tanpa nomor. --}}
        <div id="daftar-layanan" hidden class="mt-6 rounded-2xl bg-white p-5 ring-1 ring-slate-100">
            <h2 class="flex items-center gap-2 text-sm font-bold text-indigo-950">
                <i class='bx bx-support text-lg text-indigo-600'></i> Layanan yang bisa kamu hubungi
            </h2>
            @if (count($support) > 0)
                <ul class="mt-3 space-y-3">
                    @foreach ($support as $s)
                        <li class="text-sm">
                            <p class="font-bold text-slate-800">{{ $s['name'] }}</p>
                            <p class="mt-0.5 text-slate-600">{{ $s['description'] }}</p>
                            @if (!empty($s['phone']))
                                <p class="mt-1 font-bold text-indigo-800">{{ $s['phone'] }}</p>
                            @endif
                            @if (!empty($s['url']))
                                <a href="{{ $s['url'] }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-block font-bold text-indigo-700 hover:underline">Buka situs</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-2 text-sm leading-relaxed text-slate-600">
                    Kamu bisa mulai dari layanan konseling di kampusmu, puskesmas terdekat, atau orang yang kamu percaya.
                </p>
            @endif
        </div>

        <div class="mt-8 flex flex-col-reverse gap-3 min-[380px]:flex-row min-[380px]:items-start min-[380px]:justify-between">
            <button type="button" id="l-kembali"
                    class="inline-flex h-12 min-w-[9.5rem] items-center justify-center gap-2 rounded-full border border-slate-300 bg-white px-6 text-sm font-bold text-slate-700 transition hover:bg-slate-50 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
                <i class='bx bx-left-arrow-alt text-xl'></i> Kembali
            </button>
            <div class="flex flex-col items-stretch gap-1 min-[380px]:items-end">
                <button type="button" id="l-pilih" disabled
                        class="inline-flex h-12 min-w-[9.5rem] items-center justify-center gap-2 rounded-full bg-indigo-950 px-6 text-sm font-bold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-40 disabled:shadow-none disabled:hover:bg-indigo-950">
                    Pilih Langkah Ini <i class='bx bx-right-arrow-alt text-xl'></i>
                </button>
                <p class="text-xs text-slate-500">Pilih satu langkah</p>
            </div>
        </div>
    </section>

    {{-- ============ LAYAR 8: RUANG TENANG ============ --}}
    <section id="layar-penutup" hidden>
        <div class="rounded-4xl bg-white p-8 text-center shadow-xl shadow-indigo-100/60 ring-1 ring-slate-100 sm:p-12">
            <div class="relative mx-auto flex h-36 w-36 items-center justify-center" aria-hidden="true">
                <span class="absolute inset-0 rounded-full bg-indigo-100"></span>
                <span class="absolute -top-1 right-2 h-7 w-7 rounded-full bg-amber-200"></span>
                <span class="absolute bottom-2 -left-2 h-5 w-5 rounded-full bg-violet-200"></span>
                <i class='bx bx-leaf relative text-6xl text-indigo-500'></i>
            </div>

            <h1 id="p-judul" tabindex="-1" class="mt-6 text-2xl font-extrabold tracking-tight text-balance text-indigo-950 focus:outline-none sm:text-3xl"></h1>
            <p id="p-pesan" class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-slate-600"></p>

            <div class="mt-8 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
                <button type="button" id="p-selesai"
                        class="inline-flex h-12 w-full items-center justify-center rounded-full bg-indigo-950 px-8 text-sm font-bold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 sm:w-auto sm:min-w-[9.5rem]">
                    Selesai
                </button>
                <button type="button" id="p-berat"
                        class="inline-flex h-12 w-full items-center justify-center rounded-full border border-slate-300 bg-white px-6 text-sm font-bold text-slate-700 transition hover:bg-slate-50 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 sm:w-auto sm:min-w-[9.5rem]">
                    Masih berat
                </button>
                <button type="button" id="p-istirahat"
                        class="inline-flex h-12 w-full items-center justify-center rounded-full border border-slate-300 bg-white px-6 text-sm font-bold text-slate-700 transition hover:bg-slate-50 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 sm:w-auto sm:min-w-[9.5rem]">
                    Aku mau istirahat dulu
                </button>
            </div>
        </div>
    </section>

    <p id="info-simpan" hidden class="mx-auto mt-8 flex max-w-md items-start justify-center gap-2 text-center text-xs leading-relaxed text-slate-500">
        <i class='bx bx-lock-alt mt-0.5 text-base'></i>
        <span>Pilihanmu diproses di perangkat ini dan tidak dikirim ke server.</span>
    </p>
</main>
</div>

<script type="application/json" id="peta-data">@json($payload)</script>
<script src="{{ asset('js/mindway.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var data = JSON.parse(document.getElementById('peta-data').textContent);
    var $ = function (id) { return document.getElementById(id); };

    // ---------- Ambil asesmen: id di URL -> hash cadangan -> yang terbaru ----------
    var params = new URLSearchParams(window.location.search);
    var id = params.get('id');
    var record = Mindway.getAssessment(id);

    if (!record && window.location.hash.indexOf('#d=') === 0) {
        record = Mindway.decodeHash(window.location.hash.slice(3));
    }
    if (!record && !id) record = Mindway.latestAssessment();
    if (record && !Array.isArray(record.results)) record = null;

    if (!record) {
        $('state-kosong').hidden = false;
        return;
    }
    $('info-simpan').hidden = false;

    // ---------- Layar ----------
    var screens = { peta: $('layar-peta'), pertanyaan: $('layar-pertanyaan'), langkah: $('layar-langkah'), penutup: $('layar-penutup') };
    var progressStep = { pertanyaan: 1, langkah: 2 };

    function go(name) {
        Object.keys(screens).forEach(function (k) { screens[k].hidden = k !== name; });

        var n = progressStep[name];
        $('dekor').hidden = name !== 'peta';
        $('progress').hidden = !n;
        if (n) {
            $('progress-bar').style.width = (n / 3 * 100) + '%';
            $('progress-track').setAttribute('aria-valuenow', n);
            $('progress-counter').textContent = n + '/3';
        }

        var h1 = screens[name].querySelector('h1');
        if (h1) h1.focus({ preventScroll: true });
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ---------- Penyimpanan: hanya memperbarui asesmen yang memang sudah tersimpan ----------
    // (kalau hasil datang dari #hash karena localStorage gagal, tidak ada yang disimpan)
    function persistAction(action) {
        if (!Mindway.getAssessment(record.id)) return false;
        return Mindway.saveAssessment({ id: record.id, action: action });
    }

    var state = { mode: null, optionIndex: null, planSlug: null, plan: null, step: null };

    // ---------- Pembantu DOM ----------
    function el(tag, cls, text) {
        var e = document.createElement(tag);
        if (cls) e.className = cls;
        if (text !== undefined) e.textContent = text;
        return e;
    }
    function bullet(text, dotClass) {
        var li = el('li', 'flex gap-2');
        li.appendChild(el('span', 'mt-2 h-1.5 w-1.5 shrink-0 rounded-full ' + dotClass));
        li.appendChild(el('span', 'leading-relaxed', text));
        return li;
    }
    function radioRow(name, value, onChange) {
        var label = el('label', 'flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-4 text-sm font-medium text-slate-700 transition hover:border-indigo-300 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50');
        var input = el('input', 'peer sr-only');
        input.type = 'radio';
        input.name = name;
        input.value = value;
        input.addEventListener('change', onChange);
        var dot = el('span', 'flex h-5 w-5 shrink-0 rounded-full border-2 border-slate-300 bg-white transition peer-checked:border-[6px] peer-checked:border-indigo-600 peer-focus-visible:ring-2 peer-focus-visible:ring-indigo-400 peer-focus-visible:ring-offset-1');
        label.appendChild(input);
        label.appendChild(dot);
        return { label: label, input: input };
    }

    // ---------- LAYAR 5: Peta Kondisiku ----------
    function renderPeta() {
        var results = record.results.filter(function (r) { return data.patterns[r.patternSlug]; });
        var top = results.length ? data.patterns[results[0].patternSlug] : null;

        if (record.hasRedFlag) $('banner-bantuan').hidden = false;

        if (top) {
            $('peta-kosong').hidden = true;
            $('peta-kotak').hidden = false;

            results.forEach(function (r) {
                var p = data.patterns[r.patternSlug];
                var li = el('li', 'flex items-start gap-3');
                var tile = el('span', 'flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-xl shadow-sm');
                tile.style.color = p.color;
                tile.appendChild(el('i', 'bx ' + p.icon));
                var text = el('span', 'min-w-0');
                text.appendChild(el('span', 'block text-sm font-bold text-slate-900', p.title));
                if (p.description) text.appendChild(el('span', 'mt-0.5 block text-xs leading-relaxed text-slate-600', p.description));
                li.appendChild(tile);
                li.appendChild(text);
                $('peta-terjadi').appendChild(li);
            });
            // tiga kotak lainnya mengikuti pola dengan skor tertinggi
            $('peta-sekarang').appendChild(bullet(top.nowAction, 'bg-emerald-500'));
            $('peta-tunggu').appendChild(bullet(top.canWait, 'bg-sky-500'));
            $('peta-perhatian').appendChild(bullet(top.watchNote, 'bg-violet-500'));
        } else {
            $('peta-kotak').hidden = true;
            $('peta-kosong').hidden = false;
        }

        // Kalau ada tanda keselamatan, mode Bantuan ditaruh paling depan dan diberi tanda.
        var modes = data.modes.slice();
        if (record.hasRedFlag) {
            modes.sort(function (a, b) { return (b.slug === 'bantuan') - (a.slug === 'bantuan'); });
        }

        modes.forEach(function (mode) {
            var highlight = record.hasRedFlag && mode.slug === 'bantuan';
            var li = el('li');
            var btn = el('button', 'flex h-full w-full flex-col items-center justify-center gap-3 rounded-2xl bg-white px-3 py-5 text-center shadow-sm ring-1 transition hover:-translate-y-0.5 hover:shadow-md focus-visible:ring-2 focus-visible:ring-indigo-400 ' + (highlight ? 'ring-2 ring-rose-300' : 'ring-slate-100'));
            btn.type = 'button';

            var tile = el('span', 'flex h-11 w-11 items-center justify-center rounded-xl text-2xl');
            tile.style.backgroundColor = mode.color + '22';
            tile.style.color = mode.color;
            tile.appendChild(el('i', 'bx ' + mode.icon));

            btn.appendChild(tile);
            btn.appendChild(el('span', 'text-sm leading-snug font-bold text-slate-800', mode.helpLabel));
            btn.addEventListener('click', function () { startMode(mode); });

            li.appendChild(btn);
            $('daftar-mode').appendChild(li);
        });
    }

    // ---------- LAYAR 6: pertanyaan mode ----------
    function startMode(mode) {
        state = { mode: mode, optionIndex: null, planSlug: null, plan: null, step: null };

        if (!mode.question || !mode.question.options.length) {
            // mode tanpa pertanyaan: langsung ke rencana pertama
            var first = Object.keys(mode.plans)[0];
            if (!first) return;
            openPlan(first);
            return;
        }
        renderQuestion();
        go('pertanyaan');
    }

    function renderQuestion() {
        var q = state.mode.question;
        $('q-judul').textContent = q.prompt;
        $('q-bantu').textContent = q.helper || '';
        $('q-bantu').hidden = !q.helper;

        var list = $('q-opsi');
        list.textContent = '';
        q.options.forEach(function (opt, i) {
            var row = radioRow('opsi', String(i), function () {
                state.optionIndex = i;
                $('q-lanjut').disabled = false;
            });
            row.input.checked = state.optionIndex === i;
            row.label.appendChild(el('span', '', opt.label));
            var li = el('li');
            li.appendChild(row.label);
            list.appendChild(li);
        });
        $('q-lanjut').disabled = state.optionIndex === null;
    }

    $('q-kembali').addEventListener('click', function () { go('peta'); });
    $('q-lanjut').addEventListener('click', function () {
        if (state.optionIndex === null) return;
        var opt = state.mode.question.options[state.optionIndex];
        var slug = opt.plan && state.mode.plans[opt.plan] ? opt.plan : Object.keys(state.mode.plans)[0];
        if (!slug) return;
        openPlan(slug);
    });

    // ---------- LAYAR 7: langkah kecil ----------
    var stepColors = ['bg-sky-500', 'bg-amber-500', 'bg-emerald-500', 'bg-indigo-500', 'bg-violet-500'];

    function openPlan(slug) {
        state.planSlug = slug;
        state.plan = state.mode.plans[slug];
        state.step = null;
        renderSteps();
        go('langkah');
    }

    function renderSteps() {
        var plan = state.plan;
        $('l-judul').textContent = plan.title;
        $('l-intro').textContent = plan.intro;
        $('daftar-layanan').hidden = state.mode.slug !== 'bantuan';

        var list = $('l-daftar');
        list.textContent = '';
        plan.steps.forEach(function (s, i) {
            var row = radioRow('langkah', String(s.position), function () {
                state.step = s.position;
                $('l-pilih').disabled = false;
            });
            row.input.checked = state.step === s.position;

            var num = el('span', 'flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-xs font-bold text-white ' + stepColors[i % stepColors.length], String(i + 1));
            var body = el('span', 'flex-1');
            body.appendChild(el('span', 'block', s.instruction));
            if (s.minutes) body.appendChild(el('span', 'mt-0.5 block text-xs font-medium text-slate-400', '± ' + s.minutes + ' menit'));

            row.label.appendChild(num);
            row.label.appendChild(body);
            var li = el('li');
            li.appendChild(row.label);
            list.appendChild(li);
        });
        $('l-pilih').disabled = state.step === null;
    }

    $('l-kembali').addEventListener('click', function () {
        if (state.mode.question && state.mode.question.options.length) { renderQuestion(); go('pertanyaan'); }
        else go('peta');
    });

    $('l-pilih').addEventListener('click', function () {
        if (state.step === null) return;
        persistAction({
            modeSlug: state.mode.slug,
            planSlug: state.planSlug,
            chosenStep: state.step,
            outcome: null,
            finishedAt: null
        });
        $('p-judul').textContent = state.mode.closingTitle;
        $('p-pesan').textContent = state.mode.closingMessage;
        go('penutup');
    });

    // ---------- LAYAR 8: Ruang Tenang ----------
    function finish(outcome) {
        persistAction({
            modeSlug: state.mode.slug,
            planSlug: state.planSlug,
            chosenStep: state.step,
            outcome: outcome,
            finishedAt: new Date().toISOString()
        });

        if (outcome === 'masih_berat') {
            // kembali ke peta supaya bisa memilih bantuan lain
            $('catatan-berat').hidden = false;
            go('peta');
            return;
        }
        // Selesai -> lihat petanya tersimpan di Riwayat; Istirahat dulu -> beranda tanpa tuntutan apa pun
        window.location.href = outcome === 'selesai'
            ? data.riwayatUrl + '?id=' + encodeURIComponent(record.id)
            : data.homeUrl;
    }
    $('p-selesai').addEventListener('click', function () { finish('selesai'); });
    $('p-berat').addEventListener('click', function () { finish('masih_berat'); });
    $('p-istirahat').addEventListener('click', function () { finish('istirahat_dulu'); });

    // ---------- Mulai ----------
    renderPeta();
    go('peta');
});
</script>
@endsection
