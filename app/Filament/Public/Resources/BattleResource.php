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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
            ->poll('5s')
            ->defaultSort('finished_at', 'desc')
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
                TextColumn::make('finished_at')
                    ->label('Finished')
                    ->date('H:i:s | j F Y')
                    ->placeholder('TBD')
                    ->sortable(),
                TextColumn::make('winner.alias')
                    ->placeholder('TBD')
                    ->searchable(),
            ])
            ->actions([
                ViewAction::make()
                    ->visible(fn (Battle $battle) => $battle->is_finished),
            ])
            ->filters([
                Filter::make('finished_at')
                    ->form([
                        DatePicker::make('finished_at')
                            ->label('Finished after'),
                        DatePicker::make('finished_at')
                            ->label('Finished before'),
                    ])
                    ->query(function (Builder $query, $data) {
                        if (isset($data['finished_at'])) {
                            $query->whereDate('finished_at', '>=', $data['finished_at']);
                        }
                        if (isset($data['finished_at'])) {
                            $query->whereDate('finished_at', '<=', $data['finished_at']);
                        }
                    }),
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
