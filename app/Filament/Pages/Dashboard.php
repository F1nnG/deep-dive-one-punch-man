<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Leaderboard';

    protected static ?string $title = 'Leaderboard';

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function getNavigationUrl(): string
    {
        return '/';
    }
}
