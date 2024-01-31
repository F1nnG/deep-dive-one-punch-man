<?php

namespace App\Filament\Widgets;

use App\Enums\Rating;
use App\Models\Statistic;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class StatisticsWidget extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('')
            ->defaultSort('elo', 'desc')
            ->query(
                Statistic::with('user')
            )
            ->columns([
                TextColumn::make('user')
                    ->label('')
                    ->rowIndex(),
                TextColumn::make('user.alias')
                    ->searchable(),
                TextColumn::make('elo')
                    ->icon(fn (Statistic $statistic) => $statistic->rating->icon())
                    ->iconColor(fn (Statistic $statistic) => $statistic->rating->color())
                    ->tooltip(fn (Statistic $statistic) => 'Class ' . $statistic->rating->value)
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('wins')
                    ->toggleable()
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('losses')
                    ->toggleable()
                    ->alignCenter()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('rating')
                    ->multiple()
                    ->options(array_reverse(Rating::asSelectArray()))
                    ->label('Rating')
                    ->query(function ($query, $data) {
                        $data = $data['values'];
                        if (empty($data)) {
                            return $query;
                        }

                        collect($data)
                            ->map(fn ($rating) => Rating::from($rating))
                            ->each(fn ($class) => $query
                                ->orWhere('elo', '>=', $class->eloBetween()[0])
                                ->where('elo', '<', $class->eloBetween()[1])
                            );

                        return $query;
                    }),
            ]);
    }
}
