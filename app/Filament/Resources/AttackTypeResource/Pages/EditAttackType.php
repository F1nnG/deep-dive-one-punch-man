<?php

namespace App\Filament\Resources\AttackTypeResource\Pages;

use App\Filament\Resources\AttackTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAttackType extends EditRecord
{
    protected static string $resource = AttackTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
