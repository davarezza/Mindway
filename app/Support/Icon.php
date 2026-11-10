<?php

namespace App\Support;

final class Icon
{
    private const MAP = [
        'battery-low'    => 'bx-battery',
        'brain'          => 'bx-brain',
        'clipboard-list' => 'bx-clipboard',
        'door-open'      => 'bx-door-open',
        'flame'          => 'bxs-hot',
        'cloud'          => 'bx-cloud',
        'cloud-rain'     => 'bx-cloud-rain',
        'clock'          => 'bx-time-five',
        'zap'            => 'bx-bolt-circle',
        'wind'           => 'bx-wind',
        'help-circle'    => 'bx-help-circle',
    ];

    public static function bx(?string $name, string $fallback = 'bx-circle'): string
    {
        return self::MAP[$name] ?? $fallback;
    }
}
