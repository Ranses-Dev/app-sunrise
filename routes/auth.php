<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Actions\Logout;
use App\Livewire\Auth\ConfirmPassword;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\TwoFactorRecover;
use App\Livewire\Auth\TwoFactorVerify;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['throttle:60,1'])->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', Login::class)->name('login');

        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('register', Register::class)->name('register');
            Route::get('forgot-password', ForgotPassword::class)->name('password.request');
            Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');
        });
    });

    Route::middleware('auth')->group(function () {
        Route::get('verify-email', VerifyEmail::class)
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('/email/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('message', 'Verification link sent!');
        })->middleware(['auth', 'throttle:6,1'])->name('verification.send');


        Route::get('confirm-password', ConfirmPassword::class)
            ->name('password.confirm');
        Route::get('two-factor-verify', TwoFactorVerify::class)
            ->name('two-factor-verify');
        Route::get('two-factor-recover', TwoFactorRecover::class)
            ->name('two-factor-recover');
    });

    Route::post('logout', Logout::class)
        ->name('logout')->middleware('auth');
});
