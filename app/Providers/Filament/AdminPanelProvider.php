<?php

namespace App\Providers\Filament;

use App\Filament\Resources\DashboardResource\Widgets\StatsOverview;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt;
use Stephenjude\FilamentTwoFactorAuthentication\TwoFactorAuthenticationPlugin;
use Stephenjude\FilamentTwoFactorAuthentication\Middleware\ForceTwoFactorSetup;
use Stephenjude\FilamentTwoFactorAuthentication\Middleware\TwoFactorChallenge;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                StatsOverview::class
            ])
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->authGuard('web')
            /* ->emailVerification(
                promptAction: EmailVerificationPrompt::class,
                isRequired: true,
            )*/
            ->brandLogo(asset('logo.png'))
            ->plugins([
                /*TwoFactorAuthenticationPlugin::make()
                    ->enableTwoFactorAuthentication(
                       // condition: true,
                       // challengeMiddleware: TwoFactorChallenge::class,
                    ) // Enable Google 2FA
                    ->forceTwoFactorSetup(
                        condition: true, // Force 2FA setup for all users
                        middleware: ForceTwoFactorSetup::class, // Middleware to enforce 2FA
                    )
                    ->addTwoFactorMenuItem(
                        condition: true, // Show 2FA on the user menu item
                        label: '2FA', // Menu item label
                        icon: 'heroicon-s-key', // Menu item icon
                    )*/])
            ->profile();
    }
}
