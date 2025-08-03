<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Jobs\SendRecoveryCodesMail;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.basic')]
#[Title('Two Factor Recovery')]
class TwoFactorRecover extends Component
{
    public string $code = '';

    public function rules()
    {
        return [
            'code' => [
                'required',
                'regex:/^[A-Za-z0-9]{10}-[A-Za-z0-9]{10}$/',
            ],
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'The recovery code is required.',
            'code.regex' => 'The recovery code must be in the format XXXXXXXXXX-XXXXXXXXXX.',
        ];
    }

    public function render()
    {
        return view('livewire.auth.two-factor-recover');
    }

    public function verify()
    {
        $this->validate($this->rules(), $this->messages());
        $user = Auth::user();
        if ($user->two_factor_recovery_codes_app && in_array($this->code, json_decode(decrypt($user->two_factor_recovery_codes_app)))) {
            $user->two_factor_confirmed_at_app = now();
            $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes_app), true);
            $recoveryCodes = array_diff($recoveryCodes, [$this->code]);
            $user->two_factor_recovery_codes_app = encrypt(json_encode($recoveryCodes));
            $user->save();
            session()->flash('success', 'Two-factor authentication verified successfully.');

            return $this->redirect(route(name: 'dashboard', absolute: false), navigate: true);
        } else {
            session()->flash('error', 'Invalid recovery code. Please try again.');
            $this->addError('code', 'The recovery code is invalid. Please try again.');
        }
    }
}
