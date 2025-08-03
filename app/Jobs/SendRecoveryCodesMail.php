<?php

namespace App\Jobs;

use App\Mail\TwoFactorRecoveryCodesMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRecoveryCodesMail implements ShouldQueue
{
    use Queueable, Dispatchable, SerializesModels, InteractsWithQueue;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if (empty($this->user->two_factor_recovery_codes) && empty($this->user->two_factor_recovery_codes_app)) {
            Log::info('No recovery codes available for user: ' , [$this->user]);
            return;
        }
        Log::info('Sending recovery codes mail for user: ' . $this->user->email);
        $codesApp = $this->user->two_factor_recovery_codes_app
            ? json_decode(decrypt($this->user->two_factor_recovery_codes_app))
            : [];

        $codesAdmin = $this->user->two_factor_recovery_codes
            ? json_decode(decrypt($this->user->two_factor_recovery_codes))
            : [];
        Log::info('Sending recovery codes mail to user: ' . $this->user->email);
        Mail::to($this->user->email)->send(new TwoFactorRecoveryCodesMail(
            $this->user,
            $codesApp,
            $codesAdmin
        ));
    }
}
