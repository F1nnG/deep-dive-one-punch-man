<?php

namespace App\Filament\Resources\ApiKeyResource\Pages;

use App\Filament\Resources\ApiKeyResource;
use Filament\Resources\Pages\ListRecords;

class ListApiKeys extends ListRecords
{
    protected static string $resource = ApiKeyResource::class;

    public static function getNavigationItemActiveRoutePattern(): string
    {
        return 'filament/association/resources/api-keys/index'; // TODO doesnt work yet (method never hit)
    }
}
