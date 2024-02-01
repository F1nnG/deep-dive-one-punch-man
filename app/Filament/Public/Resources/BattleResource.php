<?php

namespace App\Filament\Public\Resources;

use App\Filament\Public\Resources\BattleResource\Pages\ListBattles;
use App\Filament\Public\Resources\BattleResource\Pages\ViewBattle;
use App\Models\Battle;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
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
                TextInput::make('hero')
                    ->prefixIcon(fn (Battle $battle) => $battle->winner_id === $battle->hero_id ? 'heroicon-o-trophy' : 'heroicon-o-face-frown')
                    ->prefixIconColor(fn (Battle $battle) => $battle->winner_id === $battle->hero_id ? 'success' : 'danger')
                    ->afterStateHydrated(fn (Component $component, Battle $battle) => $component->state($battle->hero->alias)),
                TextInput::make('monster')
                    ->prefixIcon(fn (Battle $battle) => $battle->winner_id === $battle->monster_id ? 'heroicon-o-trophy' : 'heroicon-o-face-frown')
                    ->prefixIconColor(fn (Battle $battle) => $battle->winner_id === $battle->monster_id ? 'success' : 'danger')
                    ->afterStateHydrated(fn (Component $component, Battle $battle) => $component->state($battle->monster->alias)),
                DatePicker::make('date')
                    ->label('Planned battle date'),
                DateTimePicker::make('finished_at')
                    ->label('Finished at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                TextColumn::make('hero.alias')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('monster.alias')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Planned at')
                    ->date('j F Y')
                    ->sortable(),
                IconColumn::make('finished')
                    ->label('Finished')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('winner.alias')
                    ->placeholder('TBD')
                    ->searchable(),
            ])
            ->actions([
                ViewAction::make()
                    ->visible(fn (Battle $battle) => $battle->finished),
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
