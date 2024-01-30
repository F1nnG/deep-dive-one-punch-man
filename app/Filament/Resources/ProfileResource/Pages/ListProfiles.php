<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ListProfiles extends ListRecords
{
    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Edit')
                ->icon('heroicon-o-pencil')
                ->url(EditProfile::getUrl(['record' => Auth::user()])),
        ];
    }

    public function table(Table $table): Table
    {
        return $table->paginated(false);
    }

    public function getTableRecord(?string $key): ?Model
    {
        return Auth::user();
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
