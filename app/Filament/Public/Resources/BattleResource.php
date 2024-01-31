<?php

namespace App\Filament\Public\Resources;

use App\Filament\Public\Resources\BattleResource\Pages;
use App\Models\Battle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BattleResource extends Resource
{
    protected static ?string $model = Battle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBattles::route('/'),
            'view' => Pages\ViewBattle::route('/{record}'),
        ];
    }
}
