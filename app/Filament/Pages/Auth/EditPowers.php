<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;

/** @deprecated Not used currently */
class EditPowers extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // protected static string $view = 'filament.pages.settings';

    public $site_name;

    protected $rules = [
        'site_name' => 'required'
    ];

    public static function canAccess(): bool
    {
        return false;
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('site_name'),
        ];
    }

    public function submit(): void
    {
        $this->validate();
    }
}
