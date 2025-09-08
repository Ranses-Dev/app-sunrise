<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\LaravelPasskeys\Models\Concerns\HasPasskeys;
use Stephenjude\FilamentTwoFactorAuthentication\TwoFactorAuthenticatable;

class User extends Authenticatable  implements FilamentUser, MustVerifyEmail, HasPasskeys
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasPermissions, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_confirmed_at_user',
        'two_factor_secret_app',
        'two_factor_recovery_codes_app',
        'two_factor_confirmed_at_app',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at_app' => 'datetime',
            'two_factor_recovery_codes_app' => 'json',
            'two_factor_recovery_codes' => 'json',

        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }
    public function canAccessPanel(Panel $panel): bool
    {
        $user = Auth::user();
        $userAdmin = $user->isAdmin();
        return  $panel->getId() === 'admin' && $userAdmin;
    }


    public static function boot()
    {
        parent::boot();
        static::updating(function (User $user) {
            if (!$user->isDirty('password') || empty($user->password)) {
                $user->password = $user->getOriginal('password');
            }
        });
    }

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_user', 'user_id', 'program_id');
    }

    public function contractMeals(): HasMany
    {
        return $this->hasMany(ContractMeal::class, 'client_service_specialist_id');
    }
    public function contractHowpas(): HasMany
    {
        return $this->hasMany(HowpaContract::class, 'client_service_specialist_id');
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class, 'housing_inspector_id');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(['admin', 'Admin']);
    }
}
