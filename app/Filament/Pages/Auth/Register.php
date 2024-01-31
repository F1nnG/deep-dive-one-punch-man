<?php

namespace App\Filament\Pages\Auth;

use App\Enums\Association;
use App\Models\User;
use App\Rules\WordCount;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Support\Enums\MaxWidth;

class Register extends BaseRegister
{
    public function getMaxWidth(): MaxWidth|string|null
    {
        return MaxWidth::FourExtraLarge;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Personal Information')
                        ->icon('heroicon-o-user')
                        ->columns()
                        ->schema([
                            TextInput::make('legal_name')
                                ->required()
                                ->placeholder('Full Legal Name'),
                            DatePicker::make('date_of_birth')
                                ->required(),
                            TextInput::make('phone')
                                ->tel()
                                ->placeholder('Phone Number'),
                            ...$this->getComponentsWithPlaceholders(),
                        ]),
                    Step::make('Hero/Monster Information')
                        ->icon('heroicon-o-user-group')
                        ->schema([
                            TextInput::make('alias')
                                ->required()
                                ->placeholder('Nickname or Alias'),
                            Select::make('association')
                                ->options(Association::asSelectArray())
                                ->required(),
                            Textarea::make('backstory')
                                ->required()
                                ->autosize()
                                ->rules([new WordCount()])
                                ->placeholder('Tell us about yourself...'),
                        ]),
                    Step::make('Powers')
                        ->icon('heroicon-o-bolt')
                        ->schema([
                            Placeholder::make('')
                                ->content('You can add or remove powers after registration by editing your profile.'),
                        ])
                ])->model(User::class)
            ]);
    }

    private function getComponentsWithPlaceholders(): array
    {
        /** @var HasPlaceholder $email */
        $email = parent::getEmailFormComponent();
        /** @var HasPlaceholder $password */
        $password = parent::getPasswordFormComponent();
        /** @var HasPlaceholder $passwordConfirmation */
        $passwordConfirmation = parent::getPasswordConfirmationFormComponent();

        return [
            $email->placeholder('Email Address'),
            $password->placeholder('Password'),
            $passwordConfirmation->placeholder('Confirm Password'),
        ];
    }
}
