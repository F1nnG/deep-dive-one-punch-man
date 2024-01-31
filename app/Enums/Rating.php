<?php

namespace App\Enums;

use App\Enums\Traits\FormatHelper;

enum Rating: string
{
    use FormatHelper;

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

    public function min(): int
    {
        return match ($this) {
            self::S => 1400,
            self::A => 1200,
            self::B => 1000,
            self::C => 0,
        };
    }

    public function max(): int
    {
        return match ($this) {
            self::S => 99999,
            self::A => 1399,
            self::B => 1199,
            self::C => 999,
        };
    }
}
