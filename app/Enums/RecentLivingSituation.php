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
}
