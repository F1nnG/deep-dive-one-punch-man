<?php

namespace App\Filament\Public\Resources;

use App\Filament\Public\Resources\BattleResource\Pages\ListBattles;
use App\Filament\Public\Resources\BattleResource\Pages\ViewBattle;
use App\Models\Battle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BattleResource extends Resource
{
    protected static ?string $model = Battle::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

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
                TextColumn::make('hero.name')
                    ->sortable(),
                TextColumn::make('monster.name')
                    ->sortable(),
                TextColumn::make('date')
                    ->date('j F Y')
                    ->sortable(),
                TextColumn::make('winner.name')
                    ->sortable(),
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBattles::route('/'),
            'view' => ViewBattle::route('/{record}'),
        ];
    }
}
