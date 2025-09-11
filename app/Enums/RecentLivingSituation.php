<?php

namespace App\Enums;

enum RecentLivingSituation: string
{
    case HOMELESS_STREETS = 'Homeless from the streets';
    case HOMELESS_SHELTER = 'Homeless from emergency Shelters';
    case TRANSITIONAL_HOUSING = 'Transitional Housing';
    case PSYCHIATRIC_FACILITY = 'Psychiatric Facility';
    case SUBSTANCE_ABUSE_TREATMENT = 'Substance abuse treatment facility';
    case MEDICAL_FACILITY = 'Hospital or Other medical facility';
    case JAIL_PRISON = 'Jail/Prison';
    case DOMESTIC_VIOLENCE = 'Domestic Violence situation';
    case LIVING_WITH_RELATIVES = 'Living with relatives / friends';
    case RENTAL_HOUSING = 'Rental Housing';
    case PARTICIPANT_OWNED = 'Participant-Owned housing';
    case OTHER = 'Other (please specify)';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::HOMELESS_STREETS => 'Homeless from the streets',
            self::HOMELESS_SHELTER => 'Homeless from emergency Shelters',
            self::TRANSITIONAL_HOUSING => 'Transitional Housing',
            self::PSYCHIATRIC_FACILITY => 'Psychiatric Facility',
            self::SUBSTANCE_ABUSE_TREATMENT => 'Substance abuse treatment facility',
            self::MEDICAL_FACILITY => 'Hospital or Other medical facility',
            self::JAIL_PRISON => 'Jail/Prison',
            self::DOMESTIC_VIOLENCE => 'Domestic Violence situation',
            self::LIVING_WITH_RELATIVES => 'Living with relatives / friends',
            self::RENTAL_HOUSING => 'Rental Housing',
            self::PARTICIPANT_OWNED => 'Participant-Owned housing',
            self::OTHER => 'Other (please specify)',
        };
    }
    public static function fromName(string $name): ?self
    {
        foreach (self::cases() as $c) {
            if ($c->name === $name) {
                return $c;
            }
        }
        return null;
    }

    // Útil: acepta tanto value como name
    public static function fromEither(string $input): ?self
    {
        return self::tryFrom($input) ?? self::fromName($input);
    }
}
