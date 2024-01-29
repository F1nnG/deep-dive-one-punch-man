<?php

namespace App\Enums;

enum Rating: string
{
    case S = 'S';
    case A = 'A';
    case B = 'B';
    case C = 'C';

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
