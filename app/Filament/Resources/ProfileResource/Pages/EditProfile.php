<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Enums\Association;
use App\Enums\Grade;
use App\Filament\Resources\ProfileResource;
use App\Filament\vendor\Select as AlternativeSelect;
use App\Models\ApiKey;
use App\Models\AttackType;
use App\Models\User;
use App\Rules\WordCount;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    protected static ?string $navigationLabel = 'Profile';

    protected ?string $heading = 'Edit Profile';

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::SevenExtraLarge;
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Tabs::make('tabs')
                    ->schema([
                        Tab::make('Personal Information')
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
                                ...self::getComponentsWithPlaceholders(),
                            ]),
                        Tab::make('Hero/Monster Information')
                            ->columns()
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
                                    ->placeholder('Tell us about yourself and how you came to be...'),
                                Textarea::make('motivation')
                                    ->required()
                                    ->autosize()
                                    ->rules([new WordCount()])
                                    ->placeholder('Tell us why you want to join...'),
                            ]),
                        Tab::make('Powers')
                            ->schema([
                                Repeater::make('powers')
                                    ->relationship('powers')
                                    ->itemLabel(fn (array $state): ?string => ($state['attack_type_id'] ?? null) ? AttackType::firstWhere('id', $state['attack_type_id'])->name : null)
                                    ->minItems(2)
                                    ->maxItems(5)
                                    ->columns()
                                    ->live()
                                    ->schema([
                                        AlternativeSelect::make('grade')
                                            ->fixIndistinctState()
                                            ->options(Grade::asSelectArray())
                                            ->required(),
                                        Select::make('attack_type_id')
                                            ->options(AttackType::all()->pluck('name', 'id'))
                                            ->label('Attack Type')
                                            ->required(),
                                    ]),
                            ]),
                        Tab::make('Api Key')
                            ->schema([
                                TextInput::make('apiKey')
                                    ->afterStateHydrated(fn (Component $component, User $user) => $component->state(ApiKey::whereUserId($user->id)->first()?->field_content ?? 'None'))
                                    ->disabled()
                                    ->label('API Key'),
                                Actions::make($this->getApiRequestAction()),
                            ]),
                    ]),
            ]);
    }

    private static function getComponentsWithPlaceholders(): array
    {
        $email = TextInput::make('email')
            ->label(__('filament-panels::pages/auth/edit-profile.form.email.label'))
            ->email()
            ->required()
            ->maxLength(255)
            ->unique(ignoreRecord: true);
        $password = TextInput::make('password')
            ->label(__('filament-panels::pages/auth/edit-profile.form.password.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->rule(Password::default())
            ->autocomplete('new-password')
            ->dehydrated(fn ($state): bool => filled($state))
            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
            ->live(debounce: 500)
            ->same('passwordConfirmation');
        $passwordConfirmation = TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::pages/auth/edit-profile.form.password_confirmation.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->visible(fn (Get $get): bool => filled($get('password')))
            ->dehydrated(false);

        return [
            $email->placeholder('Email Address'),
            $password->placeholder('Password'),
            $passwordConfirmation->placeholder('Confirm Password'),
        ];
    }

    private function getApiRequestAction(): array
    {
        if (Auth::user()->apiKey()->exists()) {
            return [];
        }

        return [
            Action::make('Request Api Key')
                ->requiresConfirmation()
                ->action(function (Action $action) {
                    $user = Auth::user();
                    if (! $user->apiKey()->exists()) {
                        $user->apiKey()->save(ApiKey::factory()->make(['is_accepted' => false]));
                    }

                    $action->redirect(EditProfile::getUrl(['record' => $user]));
                }),
        ];
    }
}
