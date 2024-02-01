<?php

namespace App\Models\Traits;

trait HasAcceptedApiCheck
{
    public static function check(?string $apiKey): bool
    {
        return static::whereKey($apiKey)
            ->where('is_accepted', true)
            ->exists();
    }
}
