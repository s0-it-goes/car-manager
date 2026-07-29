<?php

namespace App\Enums;

enum Country: string
{
    case JAPAN = 'Japan';
    case KOREA = 'Korea';
    case CHINA = 'China';

    public function label(): string
    {
        return match($this) {
            self::JAPAN => '🇯🇵 Япония',
            self::KOREA => '🇰🇷 Корея',
            self::CHINA => '🇨🇳 Китай',
        };
    }
}
