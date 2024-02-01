<?php

namespace App\Filament\Resources\AttackTypeResource\Pages;

use App\Filament\Resources\AttackTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAttackTypes extends ListRecords
{
    protected static string $resource = AttackTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
