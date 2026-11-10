@extends('layouts.main')

@section('title')
    <title>Hasil Analisis | {{ config('app.name') }}</title>
@endsection

@section('container')
<main class="mx-auto max-w-3xl px-4 py-8 sm:px-6 sm:py-12">

    <noscript>
        <p class="rounded-2xl bg-amber-50 p-4 text-sm text-amber-900 ring-1 ring-amber-200">
            Halaman ini membutuhkan JavaScript untuk menampilkan hasilmu dari perangkat ini.
        </p>
    </noscript>

    {{-- Hasil tidak ditemukan (kedaluwarsa, data browser dihapus, atau pindah perangkat) --}}
    <section id="state-kosong" hidden class="rounded-4xl bg-white p-8 text-center shadow-xl shadow-indigo-100/60 ring-1 ring-slate-100 sm:p-12">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-3xl text-slate-500">
            <i class='bx bx-error-circle'></i>
        </span>
        <h1 class="mt-5 text-2xl font-extrabold tracking-tight text-indigo-950">Hasilnya nggak ketemu</h1>
        <p class="mx-auto mt-2 max-w-sm text-sm leading-relaxed text-slate-600">
            Riwayat disimpan di browser ini selama 30 hari. Mungkin sudah kedaluwarsa, datanya terhapus, atau kamu membuka dari perangkat lain.
        </p>
        <a href="{{ $payload['startUrl'] }}"
           class="mt-6 inline-flex items-center gap-2 rounded-full bg-indigo-950 px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
            Mulai asesmen baru <i class='bx bx-right-arrow-alt text-xl'></i>
        </a>
    </section>

    <section id="state-hasil" hidden>

        {{-- Muncul kalau butir keselamatan dicentang. Daftar hanya berisi kontak yang is_verified. --}}
        <div id="banner-bantuan" hidden class="mb-6 rounded-3xl bg-rose-50 p-5 ring-1 ring-rose-200 sm:p-6">
            <p class="flex items-start gap-2 font-bold text-rose-900">
                <i class='bx bx-heart mt-0.5 text-xl'></i>
                <span>Kamu menandai ada pikiran untuk menyakiti diri sendiri atau nggak ingin melanjutkan.</span>
            </p>
            <p class="mt-2 text-sm leading-relaxed text-rose-900/80">
                Itu hal yang serius, dan kamu nggak perlu menghadapinya sendirian. Kalau kamu merasa tidak aman sekarang, hubungi layanan darurat setempat atau orang terdekat yang kamu percaya.
            </p>
            @if (count($support) > 0)
                <ul class="mt-4 space-y-2">
                    @foreach ($support as $s)
                        <li class="rounded-2xl bg-white/80 p-3 text-sm">
                            <p class="font-bold text-slate-800">{{ $s['name'] }}</p>
                            <p class="mt-0.5 text-slate-600">{{ $s['description'] }}</p>
                            @if (!empty($s['phone']))
                                <p class="mt-1 font-bold text-rose-800">{{ $s['phone'] }}</p>
                            @endif
                            @if (!empty($s['url']))
                                <a href="{{ $s['url'] }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-block font-bold text-indigo-700 hover:underline">Buka situs</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- LAYAR 4: HASIL ANALISIS --}}
        <div class="rounded-4xl bg-white p-6 shadow-xl shadow-indigo-100/60 ring-1 ring-slate-100 sm:p-10">
            <h1 tabindex="-1" class="text-2xl font-extrabold tracking-tight text-indigo-950 focus:outline-none sm:text-3xl">
                Yang paling kelihatan dari jawabanmu...
            </h1>
            <p id="hasil-subjudul" class="mt-2 text-sm text-slate-600"></p>

            <div id="hasil-panel" class="mt-6 rounded-3xl bg-indigo-50 p-5 sm:p-6">
                <h2 id="hasil-judul-pola" class="font-bold text-indigo-950"></h2>
                <ul id="hasil-pola" class="mt-4 grid gap-3 sm:grid-cols-3"></ul>
                <p id="hasil-penutup" class="mt-5 text-sm text-slate-600"></p>
            </div>

            <a id="btn-saran" href="{{ $payload['nextUrl'] }}"
               class="mt-6 flex w-full items-center justify-center gap-2 rounded-full bg-indigo-950 px-8 py-4 text-center text-sm font-bold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
                Lihat Saran &amp; Langkah Selanjutnya <i class='bx bx-right-arrow-alt text-xl'></i>
            </a>

            <div class="mt-4 text-center">
                <a href="{{ $payload['startUrl'] }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-800 hover:underline">
                    <i class='bx bx-refresh text-lg'></i> Ulangi asesmen
                </a>
            </div>

            <p id="info-simpan" hidden class="mt-6 flex items-start justify-center gap-2 text-center text-xs leading-relaxed text-slate-500">
                <i class='bx bx-lock-alt mt-0.5 text-base'></i>
                <span>Hasil ini tersimpan di browser ini selama 30 hari dan tidak dikirim ke server.</span>
            </p>
            <p id="info-tidak-simpan" hidden class="mt-6 flex items-start justify-center gap-2 text-center text-xs leading-relaxed text-amber-800">
                <i class='bx bx-info-circle mt-0.5 text-base'></i>
                <span>Browser ini tidak mengizinkan penyimpanan, jadi hasil ini tidak masuk riwayat. Simpan halaman ini kalau kamu ingin membukanya lagi.</span>
            </p>
        </div>

        <p class="mx-auto mt-6 max-w-md text-center text-xs leading-relaxed text-slate-500">
            Ini gambaran dari apa yang kamu pilih, bukan diagnosis.
        </p>
    </section>
</main>

<script type="application/json" id="hasil-data">@json($payload)</script>
<script src="{{ asset('js/mindway.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var data = JSON.parse(document.getElementById('hasil-data').textContent);
    var $ = function (id) { return document.getElementById(id); };

    var patterns = {};
    data.patterns.forEach(function (p) { patterns[p.slug] = p; });

    // ---- Ambil asesmen: dari id di URL, lalu hash cadangan, lalu yang terbaru ----
    var params = new URLSearchParams(window.location.search);
    var id = params.get('id');
    var record = Mindway.getAssessment(id);
    var fromHash = false;

    if (!record && window.location.hash.indexOf('#d=') === 0) {
        record = Mindway.decodeHash(window.location.hash.slice(3));
        fromHash = !!record;
    }
    if (!record && !id) record = Mindway.latestAssessment();

    // pastikan bentuk data masuk akal sebelum dipakai
    if (record && !Array.isArray(record.results)) record = null;

    if (!record) {
        $('state-kosong').hidden = false;
        return;
    }
    $('state-hasil').hidden = false;
    $('state-hasil').querySelector('h1').focus({ preventScroll: true });

    // ---- Banner keselamatan ----
    if (record.hasRedFlag) $('banner-bantuan').hidden = false;

    // ---- Hasil ----
    var results = record.results.filter(function (r) { return patterns[r.patternSlug]; });
    var n = results.length;

    var subjudul = $('hasil-subjudul');
    var judul = $('hasil-judul-pola');
    var penutup = $('hasil-penutup');
    var ul = $('hasil-pola');

    if (n === 0) {
        subjudul.textContent = '';
        judul.textContent = 'Belum ada pola yang menonjol dari jawabanmu.';
        ul.hidden = true;
        penutup.hidden = true;
        $('btn-saran').hidden = true;
    } else if (n === 1) {
        subjudul.textContent = 'Ini yang paling menonjol dari jawabanmu.';
        judul.textContent = 'Yang paling menonjol:';
        penutup.hidden = true;
    } else {
        subjudul.textContent = 'Kamu nggak cuma mengalami satu hal. Ada beberapa yang muncul bersamaan.';
        judul.textContent = n + ' hal yang muncul bersamaan:';
        penutup.textContent = 'Makanya semuanya terasa lebih berat daripada biasanya.';
    }

    results.forEach(function (r) {
        var p = patterns[r.patternSlug];

        var li = document.createElement('li');
        li.className = 'flex flex-col items-center rounded-2xl p-4 text-center';
        li.style.backgroundColor = p.color + '1A';

        var iconWrap = document.createElement('span');
        iconWrap.className = 'flex h-12 w-12 items-center justify-center rounded-xl bg-white text-2xl shadow-sm';
        iconWrap.style.color = p.color;
        var icon = document.createElement('i');
        icon.className = 'bx ' + p.icon;
        iconWrap.appendChild(icon);

        var title = document.createElement('h3');
        title.className = 'mt-3 text-sm font-bold text-slate-900';
        title.textContent = p.title;

        var desc = document.createElement('p');
        desc.className = 'mt-1.5 text-xs leading-relaxed text-slate-600';
        desc.textContent = p.description;

        li.appendChild(iconWrap);
        li.appendChild(title);
        li.appendChild(desc);
        ul.appendChild(li);
    });

    // ---- Tombol lanjut membawa id supaya tahap berikutnya bisa membaca asesmen yang sama ----
    if (record.id) {
        var next = $('btn-saran');
        next.href = data.nextUrl + '?id=' + encodeURIComponent(record.id) + (fromHash ? window.location.hash : '');
    }

    // ---- Info penyimpanan ----
    if (fromHash) $('info-tidak-simpan').hidden = false;
    else $('info-simpan').hidden = false;
});
</script>
@endsection
