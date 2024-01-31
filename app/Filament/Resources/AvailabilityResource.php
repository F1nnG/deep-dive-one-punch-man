<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvailabilityResource\Pages\CreateAvailability;
use App\Filament\Resources\AvailabilityResource\Pages\EditAvailability;
use App\Filament\Resources\AvailabilityResource\Pages\ListAvailabilities;
use App\Models\Availability;
use App\Queries\AvailabilityQuery;
use App\Rules\OverlappingDates;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AvailabilityResource extends Resource
{
    protected static ?string $model = Availability::class;

    protected static ?string $navigationGroup = 'User';

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('start_date')
                    ->rules([new OverlappingDates()]),
                DatePicker::make('end_date')
                    ->rules([new OverlappingDates()]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (AvailabilityQuery $query) {
                $query->whereUserId(Auth::user()->id)
                    ->orderBy('start_date');
            })
            ->columns([
                TextColumn::make('start_date')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date('d-m-Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAvailabilities::route('/'),
            'create' => CreateAvailability::route('/create'),
            'edit' => EditAvailability::route('/{record}/edit'),
        ];
    }
}
