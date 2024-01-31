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
            self::C => [0, 2400],
            self::B => [2400, 4800],
            self::A => [4800, 7200],
            self::S => [7200, PHP_INT_MAX],
        };
    }

    public static function calculate(int $elo): self
    {
        return match (true) {
            $elo < 2400 => self::C,
            $elo < 4800 => self::B,
            $elo < 7200 => self::A,
            default => self::S,
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::A, self::C, self::B => 'heroicon-o-star',
            self::S => 'heroicon-o-trophy',
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
