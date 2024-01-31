<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiKeyResource\Pages\CreateApiKey;
use App\Filament\Resources\ApiKeyResource\Pages\ListApiKeys;
use App\Models\ApiKey;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ApiKeyResource extends Resource
{
    protected static ?string $model = ApiKey::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Admin';

    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function canViewAny(): bool
    {
        return (bool)Auth::user()->is_admin;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->state('Hover to view')
                    ->tooltip(fn (ApiKey $record) => $record->key)
                    ->copyable()
                    ->copyableState(fn (ApiKey $record) => $record->key),
                TextColumn::make('user.alias')
                    ->searchable(),
                IconColumn::make('is_accepted')
                    ->label('Request accepted')
                    ->sortable()
                    ->boolean(),
                CheckboxColumn::make('is_accepted')
                    ->label('Request accepted'),
            ])
            ->filters([
                TernaryFilter::make('is_accepted')
                    ->placeholder('All')
                    ->options([
                        'true' => 'Accepted',
                        'false' => 'Pending',
                    ])
            ])
            ->bulkActions([
                BulkAction::make('Approve Request')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each(fn (ApiKey $record) => $record->update(['is_accepted' => true]))),
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApiKeys::route('/'),
            'create' => CreateApiKey::route('/create'),
        ];
    }
}
