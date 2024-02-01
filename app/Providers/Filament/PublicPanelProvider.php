<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\StatisticsWidget;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PublicPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->viteTheme('resources/css/filament/public/theme.css')
            ->id('public')
            ->path('')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Public/Resources'), for: 'App\\Filament\\Public\\Resources')
            ->discoverPages(in: app_path('Filament/Public/Pages'), for: 'App\\Filament\\Public\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                StatisticsWidget::make(),
            ])
            ->navigationItems(self::getNavigationItems())
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ]);
    }

    private static function getNavigationItems(): array
    {
        return [
            NavigationItem::make(fn () => Auth::check() ? 'Profile' : 'Login')
                ->group('User')
                ->icon(fn () => Auth::check() ? 'heroicon-o-user' : 'heroicon-o-arrow-right-end-on-rectangle')
                ->url(fn () => Auth::check() ? route('filament.association.resources.profiles.edit', Auth::user()->id) : route('filament.association.auth.login')),
            NavigationItem::make('Availabilities')
                ->group('User')
                ->visible(fn () => Auth::check())
                ->icon('heroicon-o-calendar')
                ->url(fn () => route('filament.association.resources.availabilities.index')),
            NavigationItem::make('Documentation')
                ->group('API')
                ->visible(fn () => Auth::check())
                ->icon('heroicon-o-link')
                ->url(fn () => route('filament.association.pages.api-documentation')),
            NavigationItem::make('Attack Types')
                ->group('Admin')
                ->visible(fn () => Auth::check() && Auth::user()->is_admin)
                ->icon('heroicon-o-bolt')
                ->url(fn () => route('filament.association.resources.attack-types.index')),
            NavigationItem::make('Api Keys')
                ->group('Admin')
                ->visible(fn () => Auth::check() && Auth::user()->is_admin)
                ->icon('heroicon-o-key')
                ->url(fn () => route('filament.association.resources.api-keys.index')),
        ];
    }
}
