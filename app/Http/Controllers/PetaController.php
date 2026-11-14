<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use App\Models\Pattern;
use App\Models\SupportResource;
use App\Support\Icon;

class PetaController extends Controller
{
    public function index()
    {
        $patterns = Pattern::ordered()->get()->mapWithKeys(fn ($p) => [
            $p->slug => [
                'title'       => $p->title,
                'description' => $p->description,
                'icon'        => Icon::bx($p->icon),
                'color'       => $p->color,
                'nowAction'   => $p->now_action,
                'canWait'     => $p->can_wait,
                'watchNote'   => $p->watch_note,
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
            'riwayatUrl' => route('riwayat'),
        ];

        return view('peta.index', compact('payload', 'support'));
    }
}
