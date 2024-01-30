<?php

namespace App\Enums\Traits;

trait FormatHelper
{
    public static function asSelectArray(): array
    {
        return collect(self::cases())->mapWithKeys(fn (self $item) => [$item->value => $item->name])->toArray();
    }
}
