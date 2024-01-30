<?php

namespace App\Enums;

use App\Enums\Traits\FormatHelper;

enum Grade: int
{
    use FormatHelper;

    case Primary = 1;
    case Secondary = 2;
}
