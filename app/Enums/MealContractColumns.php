<?php

namespace App\Enums;

enum MealContractColumns: string
{

    case client_full_name                 = 'client_full_name';
    case client_address_formatted       = 'client_address_formatted';
    case client_dob                   = 'client_dob';
    case client_ssn                   = 'client_ssn';
    case client_effective_date         = 'client_effective_date';
    case client_meal_number          = 'client_meal_number';

    case client_legal_status = 'client_legal_status';
    case client_identification_type = 'client_identification_type';
    case client_identification_number = 'client_identification_number';
    case client_identification_expiration_date = 'client_identification_expiration_date';

    case client_city_district = 'client_city_district';
    case client_county_district = 'client_county_district';
    case client_city = 'client_city';
    case client_email = 'client_email';
    case client_income = 'client_income';
    case client_income_type = 'client_income_type';
    case client_gender = 'client_gender';
    case client_is_deceased = 'client_is_deceased';
    case client_ethnicity = 'client_ethnicity';
    case client_healthcare_provider = 'client_healthcare_provider';
    case client_healthcare_provider_plan = 'client_healthcare_provider_plan';
    case client_housing_status = 'client_housing_status';
    case client_income_category = 'client_income_category';
    case client_service_specialist = 'client_service_specialist';
    case code = 'code';
    case program_branch = 'program_branch';
    case delivery_cost = 'delivery_cost';
    case food_cost = 'food_cost';
    case program_delivery_cost = 'program_delivery_cost';
    case termination_reason = 'termination_reason';
    case is_active = 'is_active';
    case recertification_date = 'recertification_date';
    case notes = 'notes';

    public function label(): string
    {
        return match ($this) {
            self::client_full_name => 'Client Full Name',
            self::client_address_formatted => 'Client Address',
            self::client_dob => 'Client Date of Birth',
            self::client_ssn => 'Client SSN',
            self::client_effective_date => 'Client Effective Date',
            self::client_meal_number => 'Client Meal #',

            self::client_legal_status => 'Client Legal Status',
            self::client_identification_type => 'Client ID Type',
            self::client_identification_number => 'Client ID Number',
            self::client_identification_expiration_date => 'Client ID Expiration',

            self::client_city_district => 'Client City District',
            self::client_county_district => 'Client County District',
            self::client_city => 'Client City',
            self::client_email => 'Client Email',
            self::client_income_type => 'Client Income Type',
            self::client_income => 'Client Income',
            self::client_gender => 'Client Gender',
            self::client_is_deceased => 'Client Is Deceased',
            self::client_ethnicity => 'Client Ethnicity',
            self::client_healthcare_provider => 'Client Healthcare Provider',
            self::client_healthcare_provider_plan => 'Client Healthcare Provider Plan',
            self::client_housing_status => 'Client Housing Status',
            self::client_income_category => 'Client Income Category',
            self::client_service_specialist => 'Client Service Specialist',
            self::code => 'Code',

            self::program_branch => 'Program Branch',
            self::delivery_cost => 'Delivery Cost',
            self::food_cost => 'Food Cost',
            self::program_delivery_cost => 'Program Delivery Cost',
            self::termination_reason => 'Termination Reason',
            self::is_active => 'Is Active',
            self::recertification_date => 'Re-Certification Date',
            self::notes => 'Notes',
        };
    }


    public function default(): bool
    {
        return in_array($this, [
            self::client_full_name,
            self::client_dob,
            self::client_meal_number,
            self::client_email,
            self::client_income,
            self::code,
            self::program_branch,
            self::delivery_cost,
            self::food_cost,
            self::program_delivery_cost,
            self::is_active,
            self::recertification_date,
        ], true);
    }
    public static function options(): array
    {
        return array_map(fn(self $c) => [
            'value' => $c->value,
            'label' => $c->label(),
            'default' => $c->default(),
        ], self::cases());
    }
    public static function defaultValues(): array
    {
        return array_values(array_map(fn(self $c) => $c->value, array_filter(self::cases(), fn(self $c) => $c->default())));
    }
}
