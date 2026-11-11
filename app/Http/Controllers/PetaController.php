<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use App\Models\Pattern;
use App\Models\SupportResource;
use App\Support\Icon;

class PetaController extends Controller
{
    /**
     * Layar 5 (Peta Kondisiku), 6 (pertanyaan mode), 7 (langkah kecil), dan 8 (Ruang Tenang).
     *
     * Keempat layar berada di satu halaman dan dijalankan di browser. Server mengirim seluruh
     * konten (pola, mode, pertanyaan, rencana, langkah) sebagai JSON, jadi mode yang dipilih
     * pengguna tidak muncul di URL maupun log server. Asesmen dibaca dari localStorage lewat ?id=.
     */
    public function index()
    {
        $patterns = Pattern::ordered()->get()->mapWithKeys(fn ($p) => [
            $p->slug => [
                'title'     => $p->title,
                'icon'      => Icon::bx($p->icon),
                'color'     => $p->color,
                'nowAction' => $p->now_action,   // "Yang bisa dilakukan sekarang"
                'canWait'   => $p->can_wait,     // "Yang tidak perlu diselesaikan sekarang"
                'watchNote' => $p->watch_note,   // "Yang perlu diperhatikan"
            ],
        ])->all();

        $modes = Mode::active()->ordered()
            ->with(['questions.options.plan', 'plans.steps'])
            ->get()
            ->map(function ($mode) {
                // Setiap mode memakai satu pertanyaan (urutan pertama).
                $question = $mode->questions->first();

                return [
                    'slug'           => $mode->slug,
                    'title'          => $mode->title,
                    'helpLabel'      => $mode->help_label,
                    'icon'           => Icon::bx($mode->icon),
                    'color'          => $mode->color,
                    'closingTitle'   => $mode->closing_title,
                    'closingMessage' => $mode->closing_message,
                    'question'       => $question ? [
                        'prompt'  => $question->prompt,
                        'helper'  => $question->helper,
                        'options' => $question->options->map(fn ($o) => [
                            'label' => $o->label,
                            'plan'  => $o->plan?->slug,
                        ])->values()->all(),
                    ] : null,
                    'plans' => $mode->plans->mapWithKeys(fn ($plan) => [
                        $plan->slug => [
                            'title' => $plan->title,
                            'intro' => $plan->intro,
                            'steps' => $plan->steps->map(fn ($s) => [
                                'position'    => $s->position,
                                'instruction' => $s->instruction,
                                'minutes'     => $s->estimated_minutes,
                            ])->values()->all(),
                        ],
                    ])->all(),
                ];
            })->values()->all();

        // Hanya kontak yang aktif dan sudah is_verified = true.
        $support = SupportResource::published()
            ->get(['name', 'description', 'phone', 'url'])
            ->map(fn ($s) => $s->only(['name', 'description', 'phone', 'url']))
            ->all();

        $payload = [
            'patterns'  => $patterns,
            'modes'     => $modes,
            'homeUrl'   => url('/'),
            'startUrl'  => route('asesmen'),
        ];

        return view('peta.index', compact('payload', 'support'));
    }
}
