<?php

namespace App\Livewire\Auth;

use App\Jobs\SendRecoveryCodesMail;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.basic')]
#[Title('Two Factor Verification')]
class TwoFactorVerify extends Component
{
    public string $code = '';
    public function rules()
    {
        return [
            'code' => 'required|digits:6|numeric',
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'The verification code is required.',
            'code.digits' => 'The verification code must be 6 digits.',
            'code.numeric' => 'The verification code must be a number.',
        ];
    }
    public function verify()
    {
        $google2fa = app('pragmarx.google2fa');
        $user = Auth::user();
        $this->validate($this->rules(), $this->messages());
        if ($google2fa->verifyKey($user->two_factor_secret_app, $this->code)) {
            $user->two_factor_confirmed_at_app = now();
            $user->save();
            session()->flash('success', 'Two-factor authentication verified successfully.');

            return $this->redirect(route(name: 'dashboard',  absolute: false), navigate: true);
        } else {
            session()->flash('error', 'Invalid verification code. Please try again.');
            $this->addError('code', 'The verification code is invalid. Please try again.');
        }
    }
    public function recover()
    {
        $user = Auth::user();
        if (empty($user->two_factor_secret) && empty($user->two_factor_secret_app)) {
            session()->flash('error', 'Two-factor authentication is not enabled.');
            return;
        }
        SendRecoveryCodesMail::dispatch($user);
        session()->flash('status', 'The recovery codes have been sent to your email address.');
        $this->redirect(route(name: 'two-factor-recover', absolute: false), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.two-factor-verify');
    }
}
