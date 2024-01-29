<?php

namespace App\Enums;

enum Effectiveness: string
{
    case SuperEffective = 'super_effective';
    case Effective = 'effective';
    case Neutral = 'neutral';
    case Weak = 'weak';
    case SuperWeak = 'super_weak';
}
