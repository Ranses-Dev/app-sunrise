<?php

use App\Http\Middleware\HasTwoFactorActivated;
use App\Http\Middleware\HasTwoFactorSecret;
use App\Http\Middleware\TwoFactorAuthenticator;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'two-factor' => TwoFactorAuthenticator::class,
            'has-two-factor' => HasTwoFactorSecret::class,
            'has-two-factor-activated' => HasTwoFactorActivated::class,
            'throttle' => ThrottleRequests::class
        ]);
    })
    ->withExceptions()
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('app:generate-meal-stats')->daily()
            ->onSuccess(function () {
                logger()->info('Daily meal stats generated successfully.');
            })
            ->onFailure(function () {
                logger()->error('Failed to generate daily meal stats.');
            });
    })
    ->create();
