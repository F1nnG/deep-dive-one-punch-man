<?php

namespace App\Enums;

use App\Enums\Traits\FormatHelper;

enum Association: string
{
    use FormatHelper;

    case Hero = 'hero';
    case Monster = 'monster';
}
