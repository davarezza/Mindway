@php
    $links = [
        ['label' => 'Beranda', 'href' => url('/'),          'active' => request()->is('/')],
        ['label' => 'Tentang', 'href' => url('/tentang'),   'active' => request()->is('tentang')],
        ['label' => 'Fitur',   'href' => url('/') . '#fitur', 'active' => false],
    ];
@endphp

<header class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/80 backdrop-blur">
    <nav class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6" aria-label="Navigasi utama">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-xl font-extrabold tracking-tight text-indigo-950">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-950 text-lg text-white">
                <i class='bx bx-map-alt'></i>
            </span>
            Mindway
        </a>

        {{-- Desktop --}}
        <div class="hidden items-center gap-8 md:flex">
            <ul class="flex items-center gap-7 text-sm font-semibold">
                @foreach ($links as $link)
                    <li>
                        <a href="{{ $link['href'] }}"
                           class="transition hover:text-indigo-700 {{ $link['active'] ? 'text-indigo-700' : 'text-slate-600' }}">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <a href="{{ url('/asesmen') }}"
               class="rounded-full bg-indigo-950 px-5 py-2 text-sm font-bold text-white transition hover:bg-indigo-800 focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2">
                Mulai Asesmen
            </a>
        </div>

        {{-- Tombol menu mobile --}}
        <button type="button" id="nav-toggle"
                class="flex h-10 w-10 items-center justify-center rounded-xl text-2xl text-indigo-950 hover:bg-slate-100 md:hidden"
                aria-label="Buka menu" aria-expanded="false" aria-controls="nav-mobile">
            <i class='bx bx-menu' id="nav-toggle-icon"></i>
        </button>
    </nav>

    {{-- Menu mobile --}}
    <div id="nav-mobile" class="hidden border-t border-slate-200/70 bg-white md:hidden">
        <ul class="mx-auto flex max-w-6xl flex-col gap-1 px-4 py-3 text-sm font-semibold">
            @foreach ($links as $link)
                <li>
                    <a href="{{ $link['href'] }}"
                       class="block rounded-xl px-3 py-2.5 hover:bg-slate-50 {{ $link['active'] ? 'text-indigo-700' : 'text-slate-700' }}">
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
            <li class="pt-2">
                <a href="{{ url('/asesmen') }}"
                   class="block rounded-full bg-indigo-950 px-5 py-3 text-center font-bold text-white">
                    Mulai Asesmen
                </a>
            </li>
        </ul>
    </div>
</header>

<script>
    (function () {
        var btn = document.getElementById('nav-toggle');
        var menu = document.getElementById('nav-mobile');
        var icon = document.getElementById('nav-toggle-icon');
        if (!btn || !menu) return;
        btn.addEventListener('click', function () {
            var open = menu.classList.toggle('hidden') === false;
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            icon.className = open ? 'bx bx-x' : 'bx bx-menu';
        });
    })();
</script>
