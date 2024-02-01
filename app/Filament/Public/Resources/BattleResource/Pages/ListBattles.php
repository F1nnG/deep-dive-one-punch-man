<?php

namespace App\Filament\Public\Resources\BattleResource\Pages;

use App\Filament\Public\Resources\BattleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBattles extends ListRecords
{
    protected static string $resource = BattleResource::class;

    public static function getNavigationUrl(array $parameters = []): string
    {
        return '/battles';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
