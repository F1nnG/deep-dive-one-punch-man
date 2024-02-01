<?php

namespace App\Enums;

use App\Enums\Traits\FormatHelper;
use Filament\Support\Colors\Color;

enum Rating: string
{
    use FormatHelper;

    case C = 'C';
    case B = 'B';
    case A = 'A';
    case S = 'S';

    public function eloBetween(): array
    {
        return match ($this) {
            self::C => [0, 1400],
            self::B => [1400, 1800],
            self::A => [1800, 2400],
            self::S => [2400, PHP_INT_MAX],
        };
    }

    public static function calculate(int $elo): self
    {
        return match (true) {
            $elo < 1400 => self::C,
            $elo < 1800 => self::B,
            $elo < 2400 => self::A,
            default => self::S,
        };
    }

    public function color(): array
    {
        return match ($this) {
            self::C => Color::Green,
            self::B => Color::Blue,
            self::A => Color::Red,
            self::S => Color::Yellow,
        };
    }
}
