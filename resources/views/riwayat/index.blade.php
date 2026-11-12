@extends('layouts.main')

@section('title')
    <title>Peta &amp; Riwayatku | {{ config('app.name') }}</title>
@endsection

@section('container')
<main class="mx-auto max-w-3xl px-4 py-8 sm:px-6 sm:py-12">

    <h1 tabindex="-1" class="text-3xl font-extrabold tracking-tight text-indigo-950 focus:outline-none">Peta &amp; Riwayatku</h1>
    <p class="mt-2 text-sm text-slate-600">Hasil asesmenmu yang tersimpan di browser ini.</p>

    <noscript>
        <p class="mt-6 rounded-2xl bg-amber-50 p-4 text-sm text-amber-900 ring-1 ring-amber-200">
            Halaman ini membutuhkan JavaScript untuk membaca riwayat dari perangkat ini.
        </p>
    </noscript>

    <p id="pesan" role="status" aria-live="polite" hidden class="mt-6 rounded-2xl bg-indigo-50 p-4 text-sm leading-relaxed text-indigo-900 ring-1 ring-indigo-100"></p>

    <section id="state-kosong" hidden class="mt-8 rounded-4xl bg-white p-8 text-center shadow-xl shadow-indigo-100/60 ring-1 ring-slate-100 sm:p-12">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-3xl text-indigo-600">
            <i class='bx bx-map-alt'></i>
        </span>
        <h2 class="mt-5 text-xl font-extrabold tracking-tight text-indigo-950">Belum ada riwayat</h2>
        <p class="mx-auto mt-2 max-w-sm text-sm leading-relaxed text-slate-600">
            Setelah kamu menyelesaikan asesmen, petamu muncul di sini.
        </p>
        <a href="{{ $payload['startUrl'] }}"
           class="mt-6 inline-flex h-12 items-center justify-center gap-2 rounded-full bg-indigo-950 px-8 text-sm font-bold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
            Mulai asesmen <i class='bx bx-right-arrow-alt text-xl'></i>
        </a>
    </section>

    <div id="state-isi" hidden>

        <section class="mt-8" aria-labelledby="judul-terakhir">
            <h2 id="judul-terakhir" class="text-lg font-extrabold text-indigo-950">Peta terakhirku</h2>
            <div class="mt-3 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-100 sm:p-6">
                <p id="terakhir-tanggal" class="text-xs font-bold text-slate-400"></p>
                <ul id="terakhir-pola" class="mt-3 flex flex-wrap gap-2"></ul>
                <p id="terakhir-tanpa-pola" hidden class="mt-3 text-sm text-slate-600">Belum ada pola yang menonjol dari jawabanmu.</p>
                <p id="terakhir-sekarang" class="mt-4 rounded-2xl bg-emerald-50 p-4 text-sm leading-relaxed text-slate-700 ring-1 ring-emerald-100"></p>
                <div class="mt-5 flex flex-col gap-3 sm:flex-row">
                    <a id="terakhir-peta" href="#"
                       class="inline-flex h-12 items-center justify-center gap-2 rounded-full bg-indigo-950 px-6 text-sm font-bold text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
                        Buka peta lengkap <i class='bx bx-right-arrow-alt text-xl'></i>
                    </a>
                    <a href="{{ $payload['startUrl'] }}"
                       class="inline-flex h-12 items-center justify-center gap-2 rounded-full border border-slate-300 bg-white px-6 text-sm font-bold text-slate-700 transition hover:bg-slate-50 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
                        <i class='bx bx-refresh text-lg'></i> Asesmen baru
                    </a>
                </div>
            </div>
        </section>

        <section class="mt-10" aria-labelledby="judul-riwayat">
            <div class="flex items-baseline justify-between gap-3">
                <h2 id="judul-riwayat" class="text-lg font-extrabold text-indigo-950">Riwayat</h2>
                <span id="hitung" class="text-xs font-bold text-slate-400"></span>
            </div>
            <ul id="daftar" class="mt-3 space-y-3"></ul>
        </section>

        <section class="mt-10 rounded-3xl bg-white p-5 ring-1 ring-slate-100 sm:p-6" aria-labelledby="judul-data">
            <h2 id="judul-data" class="flex items-center gap-2 text-sm font-bold text-indigo-950">
                <i class='bx bx-file text-lg text-indigo-600'></i> Simpan riwayatmu
            </h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                Riwayat hanya ada di browser ini. Hanya <span id="batas-jumlah">5</span> asesmen terakhir yang disimpan, selama <span id="batas-hari">30</span> hari,
                dan hilang kalau data browser dihapus atau kamu pindah perangkat. Download sebagai PDF kalau ingin menyimpannya lebih lama.
            </p>

            <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                <button type="button" id="btn-download"
                        class="inline-flex h-12 items-center justify-center gap-2 rounded-full bg-indigo-950 px-6 text-sm font-bold text-white transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60">
                    <i class='bx bx-download text-lg'></i> <span id="btn-download-teks">Download PDF</span>
                </button>

                <div id="hapus-semua-wrap" class="sm:ml-auto">
                    <button type="button" id="btn-hapus-semua"
                            class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-full border border-rose-200 bg-white px-6 text-sm font-bold text-rose-700 transition hover:bg-rose-50 focus-visible:ring-2 focus-visible:ring-rose-300 focus-visible:ring-offset-2 sm:w-auto">
                        <i class='bx bx-trash text-lg'></i> Hapus semua
                    </button>
                </div>
            </div>
            <p class="mt-4 flex items-start gap-2 text-xs leading-relaxed text-slate-500">
                <i class='bx bx-lock-alt mt-0.5 text-base'></i>
                <span>PDF dibuat di perangkatmu dan tidak dikirim ke server.</span>
            </p>
        </section>
    </div>
</main>

<script type="application/json" id="riwayat-data">@json($payload)</script>
<script src="{{ asset('js/mindway.js') }}"></script>
<script src="{{ asset('js/riwayat-pdf.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var data = JSON.parse(document.getElementById('riwayat-data').textContent);
    var $ = function (id) { return document.getElementById(id); };
    var highlightId = new URLSearchParams(window.location.search).get('id');
    var jspdfUrl = '{{ asset('js/vendor/jspdf.umd.min.js') }}';

    $('batas-jumlah').textContent = Mindway.MAX_ASSESSMENTS;
    $('batas-hari').textContent = Mindway.TTL_DAYS;

    var OUTCOME = {
        selesai:        { text: 'Selesai',        cls: 'bg-emerald-50 text-emerald-700 ring-emerald-100' },
        masih_berat:    { text: 'Masih berat',    cls: 'bg-amber-50 text-amber-800 ring-amber-100' },
        istirahat_dulu: { text: 'Istirahat dulu', cls: 'bg-sky-50 text-sky-700 ring-sky-100' }
    };

    function el(tag, cls, text) {
        var e = document.createElement(tag);
        if (cls) e.className = cls;
        if (text !== undefined) e.textContent = text;
        return e;
    }
    function link(href, cls, text) {
        var a = el('a', cls, text);
        a.href = href;
        return a;
    }
    function fmtDate(iso) {
        var d = new Date(iso);
        if (isNaN(d)) return '';
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) + ', ' +
            d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':');
    }
    function daysLeft(iso) {
        var left = Math.ceil((Date.parse(iso) + Mindway.TTL_DAYS * 86400000 - Date.now()) / 86400000);
        return Math.max(left, 0);
    }
    function knownResults(rec) {
        return (rec.results || []).filter(function (r) { return data.patterns[r.patternSlug]; });
    }
    function say(text) {
        $('pesan').textContent = text;
        $('pesan').hidden = !text;
    }
    function patternChips(rec, ul) {
        knownResults(rec).forEach(function (r) {
            var p = data.patterns[r.patternSlug];
            var li = el('li', 'inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-bold text-slate-800');
            li.style.backgroundColor = p.color + '22';
            var i = el('i', 'bx ' + p.icon + ' text-base');
            i.style.color = p.color;
            li.appendChild(i);
            li.appendChild(el('span', '', p.title));
            ul.appendChild(li);
        });
    }
    function actionLine(rec) {
        var a = rec.action;
        if (!a || !data.modes[a.modeSlug]) return null;
        var mode = data.modes[a.modeSlug];
        var plan = mode.plans[a.planSlug];
        return { mode: mode, step: (plan && plan.steps[a.chosenStep]) || null };
    }
    function q(rec) { return '?id=' + encodeURIComponent(rec.id); }

    function render() {
        var list = Mindway.listAssessments();
        var empty = list.length === 0;

        $('state-kosong').hidden = !empty;
        $('state-isi').hidden = empty;
        if (empty) return;

        var main = list[0];
        if (highlightId) list.forEach(function (x) { if (x.id === highlightId) main = x; });

        $('terakhir-tanggal').textContent = (main === list[0] ? 'TERAKHIR · ' : '') + fmtDate(main.createdAt);
        $('terakhir-pola').textContent = '';
        patternChips(main, $('terakhir-pola'));
        var known = knownResults(main);
        $('terakhir-tanpa-pola').hidden = known.length > 0;
        $('terakhir-sekarang').hidden = known.length === 0;
        if (known.length) {
            $('terakhir-sekarang').textContent = '';
            $('terakhir-sekarang').appendChild(el('span', 'font-bold text-emerald-700', 'Yang bisa dilakukan sekarang: '));
            $('terakhir-sekarang').appendChild(document.createTextNode(data.patterns[known[0].patternSlug].nowAction));
        }
        $('terakhir-peta').href = data.petaUrl + q(main);

        $('hitung').textContent = list.length + ' dari ' + Mindway.MAX_ASSESSMENTS;
        var ul = $('daftar');
        ul.textContent = '';
        list.forEach(function (rec) {
            var li = el('li', 'rounded-2xl bg-white p-4 shadow-sm ring-1 sm:p-5 ' + (rec.id === highlightId ? 'ring-2 ring-indigo-300' : 'ring-slate-100'));

            var head = el('div', 'flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1');
            head.appendChild(el('p', 'text-sm font-bold text-slate-800', fmtDate(rec.createdAt)));
            head.appendChild(el('p', 'text-xs text-slate-400', 'Tersimpan ' + daysLeft(rec.createdAt) + ' hari lagi'));
            li.appendChild(head);

            if (knownResults(rec).length) {
                var chips = el('ul', 'mt-3 flex flex-wrap gap-2');
                patternChips(rec, chips);
                li.appendChild(chips);
            } else {
                li.appendChild(el('p', 'mt-3 text-sm text-slate-500', 'Belum ada pola yang menonjol.'));
            }

            var act = actionLine(rec);
            if (act) {
                var row = el('p', 'mt-3 flex flex-wrap items-center gap-2 text-sm text-slate-600');
                var m = el('span', 'inline-flex items-center gap-1 font-bold');
                m.style.color = act.mode.color;
                m.appendChild(el('i', 'bx ' + act.mode.icon));
                m.appendChild(document.createTextNode(act.mode.title));
                row.appendChild(m);
                if (act.step) row.appendChild(el('span', '', act.step));
                var oc = OUTCOME[rec.action.outcome];
                if (oc) row.appendChild(el('span', 'rounded-full px-2.5 py-0.5 text-xs font-bold ring-1 ' + oc.cls, oc.text));
                li.appendChild(row);
            }

            var btns = el('div', 'mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm font-bold');
            btns.appendChild(link(data.hasilUrl + q(rec), 'text-indigo-800 hover:underline', 'Lihat hasil'));
            if (knownResults(rec).length) btns.appendChild(link(data.petaUrl + q(rec), 'text-indigo-800 hover:underline', 'Buka peta'));

            var del = el('span', 'ml-auto inline-flex items-center gap-3');
            var delBtn = el('button', 'text-rose-700 hover:underline focus-visible:ring-2 focus-visible:ring-rose-300', 'Hapus');
            delBtn.type = 'button';
            delBtn.addEventListener('click', function () {
                del.textContent = '';
                del.appendChild(el('span', 'text-xs font-medium text-slate-500', 'Hapus asesmen ini?'));
                var yes = el('button', 'text-rose-700 hover:underline', 'Ya, hapus');
                yes.type = 'button';
                yes.addEventListener('click', function () {
                    Mindway.removeAssessment(rec.id);
                    if (rec.id === highlightId) highlightId = null;
                    say('Satu asesmen dihapus.');
                    render();
                });
                var no = el('button', 'text-slate-600 hover:underline', 'Batal');
                no.type = 'button';
                no.addEventListener('click', render);
                del.appendChild(yes);
                del.appendChild(no);
                yes.focus();
            });
            del.appendChild(delBtn);
            btns.appendChild(del);

            li.appendChild(btns);
            ul.appendChild(li);
        });
    }

    function loadJsPdf() {
        if (window.jspdf && window.jspdf.jsPDF) return Promise.resolve(window.jspdf.jsPDF);
        return new Promise(function (resolve, reject) {
            var s = document.createElement('script');
            s.src = jspdfUrl;
            s.onload = function () {
                if (window.jspdf && window.jspdf.jsPDF) resolve(window.jspdf.jsPDF);
                else reject(new Error('jspdf'));
            };
            s.onerror = function () { reject(new Error('jspdf')); };
            document.head.appendChild(s);
        });
    }

    $('btn-download').addEventListener('click', function () {
        var btn = $('btn-download');
        var list = Mindway.listAssessments();
        if (!list.length) return;
        btn.disabled = true;
        $('btn-download-teks').textContent = 'Menyiapkan PDF...';

        loadJsPdf().then(function (jsPDF) {
            var doc = Mindway.buildPdf(jsPDF, list, data);
            doc.save(Mindway.pdfFileName());
            say('PDF riwayatmu sudah didownload. Simpan di tempat yang aman, karena isinya hasil asesmenmu.');
        }).catch(function () {
            say('PDF belum bisa dibuat. Coba muat ulang halaman ini lalu download lagi.');
        }).then(function () {
            btn.disabled = false;
            $('btn-download-teks').textContent = 'Download PDF';
        });
    });

    var wrap = $('hapus-semua-wrap');
    var wrapHtml = wrap.innerHTML;
    function resetHapusSemua() {
        wrap.innerHTML = wrapHtml;
        $('btn-hapus-semua').addEventListener('click', askClear);
    }
    function askClear() {
        wrap.textContent = '';
        var box = el('div', 'flex flex-col gap-2 rounded-2xl bg-rose-50 p-3 ring-1 ring-rose-200 sm:flex-row sm:items-center');
        box.appendChild(el('span', 'text-xs font-bold text-rose-900', 'Hapus semua riwayat di browser ini?'));
        var yes = el('button', 'inline-flex h-10 items-center justify-center rounded-full bg-rose-700 px-4 text-xs font-bold text-white hover:bg-rose-800', 'Ya, hapus semua');
        yes.type = 'button';
        yes.addEventListener('click', function () {
            Mindway.clearAll();
            highlightId = null;
            resetHapusSemua();
            say('Semua riwayat dihapus dari browser ini.');
            render();
        });
        var no = el('button', 'inline-flex h-10 items-center justify-center rounded-full border border-slate-300 bg-white px-4 text-xs font-bold text-slate-700 hover:bg-slate-50', 'Batal');
        no.type = 'button';
        no.addEventListener('click', resetHapusSemua);
        box.appendChild(yes);
        box.appendChild(no);
        wrap.appendChild(box);
        no.focus();
    }
    $('btn-hapus-semua').addEventListener('click', askClear);

    render();
});
</script>
@endsection
