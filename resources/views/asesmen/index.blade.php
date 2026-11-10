@extends('layouts.main')

@section('title')
    <title>Pilih Kondisi | {{ config('app.name') }}</title>
@endsection

@section('container')
<main class="mx-auto max-w-3xl px-4 py-8 sm:px-6 sm:py-12">

    {{-- Progres: 1/3 pilih kondisi, 2/3 asesmen, 3/3 hasil --}}
    <div class="flex items-center gap-4">
        <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-slate-200"
             role="progressbar" aria-label="Progres asesmen" aria-valuemin="1" aria-valuemax="3" aria-valuenow="1" id="progress-track">
            <div id="progress-bar" class="h-full rounded-full bg-indigo-950 transition-all duration-300" style="width: 33.33%"></div>
        </div>
        <span id="progress-counter" class="text-xs font-bold text-slate-500">1/3</span>
    </div>

    <noscript>
        <p class="mt-6 rounded-2xl bg-amber-50 p-4 text-sm text-amber-900 ring-1 ring-amber-200">
            Halaman ini membutuhkan JavaScript supaya jawabanmu bisa diproses langsung di perangkatmu.
        </p>
    </noscript>

    {{-- ============ LAYAR 2: PILIH KONDISI ============ --}}
    <section id="step-kondisi" class="mt-8">
        <h1 tabindex="-1" class="text-3xl font-extrabold tracking-tight text-indigo-950 focus:outline-none">Kamu lagi...</h1>
        <p class="mt-2 text-sm text-slate-600">Pilih satu atau lebih yang paling menggambarkan kondisi kamu.</p>

        <ul class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">
            @foreach ($payload['conditions'] as $c)
                <li>
                    <label class="relative block h-full cursor-pointer">
                        <input type="checkbox" name="kondisi" value="{{ $c['slug'] }}" class="peer sr-only"
                               @if (in_array($c['slug'], $payload['preselect'])) checked @endif>
                        <span class="flex h-full min-h-32 flex-col items-center justify-center gap-3 rounded-2xl border-2 border-transparent bg-white px-3 py-5 text-center shadow-sm ring-1 ring-slate-100 transition hover:-translate-y-0.5 hover:shadow-md peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-focus-visible:ring-2 peer-focus-visible:ring-indigo-400">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl text-2xl"
                                  style="background-color: {{ $c['color'] }}22; color: {{ $c['color'] }}">
                                <i class='bx {{ $c['icon'] }}'></i>
                            </span>
                            <span class="text-sm leading-snug font-bold text-slate-800">{{ $c['title'] }}</span>
                        </span>
                        <i class='bx bxs-check-circle absolute top-2 right-2 text-xl text-indigo-600 opacity-0 transition peer-checked:opacity-100' aria-hidden="true"></i>
                    </label>
                </li>
            @endforeach
        </ul>

        <div class="mt-8 flex items-start justify-between gap-3">
            <a href="{{ url('/') }}" id="btn-kembali-home" title="Kembali ke Beranda"
               class="inline-flex h-12 min-w-38 items-center justify-center gap-2 rounded-full px-6 text-sm font-bold border border-slate-300 bg-white text-slate-700 transition hover:bg-slate-50 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
                <i class='bx bx-left-arrow-alt text-xl'></i> Kembali
            </a>
            <div class="flex flex-col items-end gap-1">
                <button type="button" id="btn-lanjut-kondisi" disabled
                        class="inline-flex h-12 min-w-38 items-center justify-center gap-2 rounded-full px-6 text-sm font-bold bg-indigo-950 text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-40 disabled:shadow-none disabled:hover:bg-indigo-950">
                    Lanjut <i class='bx bx-right-arrow-alt text-xl'></i>
                </button>
                <p id="hint-kondisi" class="text-xs text-slate-500" aria-live="polite">Pilih minimal satu</p>
            </div>
        </div>
    </section>

    {{-- ============ LAYAR 3: ASESMEN SINGKAT ============ --}}
    <section id="step-sinyal" class="mt-8" hidden>
        <h1 tabindex="-1" class="text-2xl font-extrabold tracking-tight text-indigo-950 focus:outline-none sm:text-3xl">
            Biar kita lebih paham, apa yang paling sering terjadi belakangan ini?
        </h1>
        <p class="mt-2 text-sm text-slate-600">Pilih yang paling sesuai dengan kondisi kamu. Boleh lebih dari satu.</p>

        <ul id="daftar-sinyal" class="mt-6 divide-y divide-slate-100 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100"></ul>

        <div class="mt-8 flex items-start justify-between gap-3">
            <button type="button" id="btn-kembali"
                    class="inline-flex h-12 min-w-38 items-center justify-center gap-2 rounded-full px-6 text-sm font-bold border border-slate-300 bg-white text-slate-700 transition hover:bg-slate-50 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
                <i class='bx bx-left-arrow-alt text-xl'></i> Kembali
            </button>
            <div class="flex flex-col items-end gap-1">
                <button type="button" id="btn-lanjut-sinyal" disabled
                        class="inline-flex h-12 min-w-38 items-center justify-center gap-2 rounded-full px-6 text-sm font-bold bg-indigo-950 text-white shadow-lg shadow-indigo-900/20 transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-40 disabled:shadow-none disabled:hover:bg-indigo-950">
                    Lanjut <i class='bx bx-right-arrow-alt text-xl'></i>
                </button>
                <p id="hint-sinyal" class="text-xs text-slate-500" aria-live="polite">Pilih minimal satu</p>
            </div>
        </div>
    </section>

    <p class="mx-auto mt-12 flex max-w-md items-start justify-center gap-2 text-center text-xs leading-relaxed text-slate-500">
        <i class='bx bx-lock-alt mt-0.5 text-base'></i>
        <span>Jawabanmu diproses di perangkat ini dan tidak dikirim ke server.</span>
    </p>
</main>

<script type="application/json" id="asesmen-data">@json($payload)</script>
<script src="{{ asset('js/mindway.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var data = JSON.parse(document.getElementById('asesmen-data').textContent);
    var $ = function (id) { return document.getElementById(id); };

    var stepKondisi = $('step-kondisi');
    var stepSinyal  = $('step-sinyal');
    var bar         = $('progress-bar');
    var track       = $('progress-track');
    var counter     = $('progress-counter');

    var condInputs  = Array.prototype.slice.call(document.querySelectorAll('input[name="kondisi"]'));
    var btnKondisi  = $('btn-lanjut-kondisi');
    var hintKondisi = $('hint-kondisi');

    var list        = $('daftar-sinyal');
    var btnBack     = $('btn-kembali');
    var btnFinish   = $('btn-lanjut-sinyal');
    var hintSinyal  = $('hint-sinyal');

    var checked = {};

    function selectedConditions() {
        return condInputs.filter(function (i) { return i.checked; }).map(function (i) { return i.value; });
    }
    function checkedSignals() {
        return Object.keys(checked).filter(function (k) { return checked[k]; });
    }

    function setProgress(n) {
        bar.style.width = (n / 3 * 100) + '%';
        track.setAttribute('aria-valuenow', n);
        counter.textContent = n + '/3';
    }

    function show(step) {
        var isKondisi = step === 'kondisi';
        stepKondisi.hidden = !isKondisi;
        stepSinyal.hidden = isKondisi;
        setProgress(isKondisi ? 1 : 2);
        var h1 = (isKondisi ? stepKondisi : stepSinyal).querySelector('h1');
        h1.focus({ preventScroll: true });
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function updateKondisi() {
        var n = selectedConditions().length;
        btnKondisi.disabled = n === 0;
        hintKondisi.textContent = n === 0 ? 'Pilih minimal satu' : n + ' dipilih';
    }

    function updateSinyal() {
        var n = checkedSignals().length;
        btnFinish.disabled = n === 0;
        hintSinyal.textContent = n === 0 ? 'Pilih minimal satu' : n + ' dipilih';
    }

    function buildSignalList(conditionSlugs) {
        var count = {}, order = {}, red = [], idx = 0;

        conditionSlugs.forEach(function (cs) {
            var cond = data.conditions.filter(function (c) { return c.slug === cs; })[0];
            if (!cond) return;
            cond.signals.forEach(function (s) {
                var sig = data.signals[s];
                if (!sig) return;
                if (sig.redFlag) { if (red.indexOf(s) < 0) red.push(s); return; }
                count[s] = (count[s] || 0) + 1;
                if (!(s in order)) order[s] = idx++;
            });
        });

        var normal = Object.keys(count)
            .sort(function (a, b) { return count[b] - count[a] || order[a] - order[b]; })
            .slice(0, data.maxSignals);

        return normal.concat(red);
    }

    function renderSignals() {
        var slugs = buildSignalList(selectedConditions());
        Object.keys(checked).forEach(function (k) { if (slugs.indexOf(k) < 0) delete checked[k]; });

        list.textContent = '';
        slugs.forEach(function (slug) {
            var sig = data.signals[slug];

            var li = document.createElement('li');
            var label = document.createElement('label');
            label.className = 'flex cursor-pointer items-center gap-3 px-4 py-4 text-sm font-medium text-slate-700 transition hover:bg-slate-50 has-[:checked]:bg-indigo-50/60';

            var input = document.createElement('input');
            input.type = 'checkbox';
            input.value = slug;
            input.className = 'peer sr-only';
            input.checked = !!checked[slug];

            var box = document.createElement('span');
            box.className = 'flex h-5 w-5 shrink-0 items-center justify-center rounded-md border-2 border-slate-300 text-transparent transition peer-checked:border-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white peer-focus-visible:ring-2 peer-focus-visible:ring-indigo-400 peer-focus-visible:ring-offset-1';
            box.innerHTML = "<i class='bx bx-check text-base'></i>";

            var text = document.createElement('span');
            text.textContent = sig.label;

            label.appendChild(input);
            label.appendChild(box);
            label.appendChild(text);
            li.appendChild(label);
            list.appendChild(li);
        });

        updateSinyal();
    }

    condInputs.forEach(function (i) { i.addEventListener('change', updateKondisi); });

    btnKondisi.addEventListener('click', function () {
        if (selectedConditions().length === 0) return;
        renderSignals();
        show('sinyal');
    });

    btnBack.addEventListener('click', function () { show('kondisi'); });

    list.addEventListener('change', function (e) {
        if (e.target && e.target.type === 'checkbox') {
            checked[e.target.value] = e.target.checked;
            updateSinyal();
        }
    });

    btnFinish.addEventListener('click', function () {
        var signalSlugs = checkedSignals();
        if (signalSlugs.length === 0) return;
        btnFinish.disabled = true;

        var scored = Mindway.scorePatterns(signalSlugs, data.signals, data.patterns);
        var record = {
            id: Mindway.uuid(),
            createdAt: new Date().toISOString(),
            conditionSlugs: selectedConditions(),
            signalSlugs: signalSlugs,
            hasRedFlag: scored.hasRedFlag,
            results: scored.results,
            action: null
        };

        var saved = Mindway.saveAssessment(record);
        var url = data.resultUrl + '?id=' + encodeURIComponent(record.id);
        if (!saved) url += '#d=' + Mindway.encodeHash(record);
        window.location.href = url;
    });

    updateKondisi();
});
</script>
@endsection
