{{-- Banner keselamatan. Dipakai di asesmen/hasil dan peta/index. Wajib dikirim: $support (kontak is_verified). Tampil lewat JS (hapus atribut hidden). --}}
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
