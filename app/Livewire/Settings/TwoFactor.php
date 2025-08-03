<?php

namespace App\Livewire\Settings;

use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PragmaRX\Recovery\Recovery;

class TwoFactor extends Component
{
    public string|null $secret = '';
    public string $qrCodeUrl = '';
    public bool $showQrCode = false;
    public bool $showingRecoveryCodes = false;
    public string|null $recoveryCodes = null;
    public string $code = '';
    public function render()
    {
        return view('livewire.settings.two-factor');
    }

    public function mount()
    {
        $google2fa = app('pragmarx.google2fa');

        $user = Auth::user();
        $this->secret = $user->two_factor_secret_app;
        $this->recoveryCodes = is_array($user->two_factor_recovery_codes_app)
            ? json_encode($user->two_factor_recovery_codes_app)
            : ($user->two_factor_recovery_codes_app ?? '[]');
        if (empty($this->secret)) {
            $this->secret = $google2fa->generateSecretKey();
            $this->recoveryCodes = (new Recovery())->toJson();
            $this->qrCodeUrl = $google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $this->secret
            );
        }
    }
    public function toggleQrCode()
    {
        $this->showQrCode = !$this->showQrCode;
    }
    public function toggleRecoveryCodes()
    {
        $this->showingRecoveryCodes = !$this->showingRecoveryCodes;
    }
    public function enableTwoFactor()
    {
        $google2fa = app('pragmarx.google2fa');
        $this->validate([
            'code' => ['required', 'numeric', 'digits:6', function ($attribute, $value, $fail) use ($google2fa) {
                if (!$google2fa->verifyKey($this->secret, $value)) {
                    $fail('The :attribute code is invalid.');
                }
            }],
        ]);

        $user = Auth::user();
        $user->two_factor_secret_app = $this->secret;
        $user->two_factor_recovery_codes_app = encrypt($this->recoveryCodes);
        $user->two_factor_confirmed_at_app = now();
        $user->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __('Two-factor authentication enabled successfully.'));
    }

    public function disableTwoFactor()
    {
        $user = Auth::user();
        $user->two_factor_secret_app = null;
        $user->two_factor_recovery_codes_app = [];
        $user->two_factor_confirmed_at_app = null;
        $user->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __('Two-factor authentication disabled successfully.'));
    }
}
