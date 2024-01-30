<?php

namespace App\Filament\Pages\Auth;

use App\Enums\Association;
use App\Enums\Grade;
use App\Filament\vendor\Select as AlternativeSelect;
use App\Models\AttackType;
use App\Models\User;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\HtmlString;

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
                                ->placeholder('Tell us about yourself...'),
                        ]),
                    Step::make('Powers')
                        ->icon('heroicon-o-bolt')
                        ->schema([
                            Placeholder::make('')
                                ->content($this->getDescriptiveText()),
                            Repeater::make('powers')
                                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                ->minItems(2)
                                ->maxItems(5)
                                ->columns()
                                ->schema([
                                    AlternativeSelect::make('grade')
                                        ->fixIndistinctState()
                                        ->options(Grade::asSelectArray())
                                        ->required(),
                                    Select::make('attack_type')
                                        ->options(AttackType::all()->pluck('name', 'id'))
                                        ->required(),
                                    TextInput::make('name')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->placeholder('Power Name'),
                                    Textarea::make('description')
                                        ->required()
                                        ->autosize()
                                        ->placeholder('Power Description'),
                                ]),
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

    private function getDescriptiveText(): HtmlString
    {
        return new HtmlString('
                <strong>NOTES</strong><br>
                You must add between two and five powers, with one of them being a Primary Power.<br>
                You can add or remove powers after registration by editing your profile.
            ');
    }
}
