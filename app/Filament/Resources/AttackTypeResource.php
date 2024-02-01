<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttackTypeResource\Pages\CreateAttackType;
use App\Filament\Resources\AttackTypeResource\Pages\EditAttackType;
use App\Filament\Resources\AttackTypeResource\Pages\ListAttackTypes;
use App\Models\AttackType;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AttackTypeResource extends Resource
{
    protected static ?string $model = AttackType::class;

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    public static function canViewAny(): bool
    {
        return Auth::user()->is_admin;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Effects')
                    ->schema([
                        Select::make('effective_against')
                            ->options(fn (AttackType $attackType) => AttackType::whereNot('id', $attackType->id)->pluck('name', 'id')->toArray())
                            ->required(),
                        Select::make('weak_against')
                            ->options(fn (AttackType $attackType) => AttackType::whereNot('id', $attackType->id)->pluck('name', 'id')->toArray())
                            ->required(),
                    ]),
                TextInput::make('name')
                    ->required(),
                TextInput::make('damage')
                    ->numeric()
                    ->required(),
                Textarea::make('description')
                    ->autosize()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('damage')
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('name')
                    ->alignCenter()
                    ->badge()
                    ->sortable(),
                TextColumn::make('effectiveAgainst.name')
                    ->alignCenter()
                    ->color('success')
                    ->badge()
                    ->label('Effective Against'),
                TextColumn::make('weakAgainst.name')
                    ->alignCenter()
                    ->color('danger')
                    ->badge()
                    ->label('Weak Against'),
                TextColumn::make('description')
                    ->limit(35)
                    ->alignCenter()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttackTypes::route('/'),
            'create' => CreateAttackType::route('/create'),
            'edit' => EditAttackType::route('/{record}/edit'),
        ];
    }
}
