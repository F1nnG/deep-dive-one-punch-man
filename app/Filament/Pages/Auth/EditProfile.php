<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('legal_name')
                    ->required()
                    ->placeholder('Full Legal Name'),
                DatePicker::make('date_of_birth')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->placeholder('Phone Number'),
                Register::getComponentsWithPlaceholders($this)
            ]);
    }
}

// TODO move Register form so it can be used here too
