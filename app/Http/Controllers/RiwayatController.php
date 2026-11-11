<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use App\Models\Pattern;
use App\Support\Icon;

class RiwayatController extends Controller
{
    public function index()
    {
        $patterns = Pattern::ordered()->get()->mapWithKeys(fn ($p) => [
            $p->slug => [
                'title'     => $p->title,
                'icon'      => Icon::bx($p->icon),
                'color'     => $p->color,
                'nowAction' => $p->now_action,
            ],
        ])->all();

        $modes = Mode::active()->ordered()->with('plans.steps')->get()->mapWithKeys(fn ($m) => [
            $m->slug => [
                'title' => $m->title,
                'icon'  => Icon::bx($m->icon),
                'color' => $m->color,
                'plans' => $m->plans->mapWithKeys(fn ($plan) => [
                    $plan->slug => [
                        'title' => $plan->title,
                        'steps' => $plan->steps->mapWithKeys(fn ($s) => [$s->position => $s->instruction])->all(),
                    ],
                ])->all(),
            ],
        ])->all();

        $payload = [
            'patterns'  => $patterns,
            'modes'     => $modes,
            'startUrl'  => route('asesmen'),
            'hasilUrl'  => route('asesmen.hasil'),
            'petaUrl'   => route('peta'),
            'homeUrl'   => url('/'),
        ];

        return view('riwayat.index', compact('payload'));
    }
}
