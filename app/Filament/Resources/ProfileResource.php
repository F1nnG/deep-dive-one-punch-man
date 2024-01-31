<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages\EditProfile;
use App\Filament\Resources\ProfileResource\Pages\ListProfiles;
use App\Models\User;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;

class ProfileResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Profile';

    protected static ?string $navigationGroup = 'User';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getNavigationUrl(): string
    {
        return EditProfile::getNavigationUrl(['record' => Auth::user()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProfiles::route('/'),
            'edit' => EditProfile::route('/edit/{record}'),
        ];
    }
}
