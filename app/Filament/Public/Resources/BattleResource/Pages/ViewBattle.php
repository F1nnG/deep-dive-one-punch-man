<?php

namespace App\Filament\Public\Resources\BattleResource\Pages;

use App\Filament\Public\Resources\BattleResource;
use Filament\Resources\Pages\ViewRecord;

class ViewBattle extends ViewRecord
{
    protected static string $resource = BattleResource::class;

    protected static string $view = 'filament.resources.battles.pages.view-battle';
}
