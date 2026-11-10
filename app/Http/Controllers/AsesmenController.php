<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use App\Models\Emotion;
use App\Models\Pattern;
use App\Models\SupportResource;
use App\Support\Icon;
use Illuminate\Http\Request;

class AsesmenController extends Controller
{
    /**
     * Layar 2 (Pilih Kondisi) dan layar 3 (Asesmen Singkat).
     *
     * Kedua layar berada di satu halaman dan dijalankan penuh di browser. Pilihan pengguna
     * (kondisi dan sinyal) TIDAK dikirim ke server, jadi tidak masuk log. Server hanya
     * mengirim konten sebagai JSON.
     */
    public function index(Request $request)
    {
        $conditions = Condition::active()->ordered()->with('signals.pattern')->get();

        // Chip perasaan di Home (?emosi=capek) menandai kondisi yang relevan lebih dulu.
        $preselect = [];
        if ($request->filled('emosi')) {
            $emotion = Emotion::where('slug', $request->query('emosi'))->first();
            if ($emotion) {
                $preselect = $emotion->conditions->pluck('slug')->all();
            }
        }

        $signals = [];
        $conditionList = [];

        foreach ($conditions as $condition) {
            $slugs = [];

            foreach ($condition->signals as $signal) {
                $slugs[] = $signal->slug;

                $signals[$signal->slug] ??= [
                    'label'   => $signal->label,
                    'pattern' => $signal->pattern?->slug,
                    'weight'  => $signal->weight,
                    'redFlag' => $signal->is_red_flag,
                ];
            }

            $conditionList[] = [
                'slug'    => $condition->slug,
                'title'   => $condition->title,
                'icon'    => Icon::bx($condition->icon),
                'color'   => $condition->color,
                'signals' => $slugs,
            ];
        }

        $payload = [
            'conditions'  => $conditionList,
            'signals'     => $signals,
            'patterns'    => Pattern::ordered()->pluck('sort_order', 'slug')->all(), // slug => urutan (pemecah seri skor)
            'preselect'   => $preselect,
            'maxSignals'  => 8,                                // batas butir biasa per asesmen (di luar butir keselamatan)
            'resultUrl'   => route('asesmen.hasil'),
            'nextUrl'     => url('/peta-kondisi'),             // tahap berikutnya
        ];

        return view('asesmen.index', compact('payload'));
    }

    /**
     * Layar 4 (Hasil Analisis). Isi hasilnya dibangun di browser dari riwayat localStorage;
     * server hanya mengirim data pola dan daftar bantuan yang sudah diverifikasi.
     */
    public function hasil()
    {
        $patterns = Pattern::ordered()->get()->map(fn ($p) => [
            'slug'        => $p->slug,
            'title'       => $p->title,
            'description' => $p->description,
            'icon'        => Icon::bx($p->icon),
            'color'       => $p->color,
            'nowAction'   => $p->now_action,
            'canWait'     => $p->can_wait,
            'watchNote'   => $p->watch_note,
        ])->values()->all();

        // Hanya kontak yang aktif dan sudah is_verified = true.
        $support = SupportResource::published()
            ->get(['name', 'description', 'phone', 'url'])
            ->map(fn ($s) => $s->only(['name', 'description', 'phone', 'url']))
            ->all();

        $payload = [
            'patterns'  => $patterns,
            'startUrl'  => route('asesmen'),
            'nextUrl'   => url('/peta-kondisi'),
        ];

        return view('asesmen.hasil', compact('payload', 'support'));
    }
}
