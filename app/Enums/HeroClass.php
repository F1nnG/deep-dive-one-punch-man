<?php

namespace App\Enums;

enum HeroClass: string
{
    case C = 'C';
    case B = 'B';
    case A = 'A';
    case S = 'S';

    public static function calculate(int $elo): self
    {
        if ($elo < 1000) {
            return self::C;
        }

        if ($elo < 1200) {
            return self::B;
        }

        if ($elo < 1400) {
            return self::A;
        }

        return self::S;
    }
}
