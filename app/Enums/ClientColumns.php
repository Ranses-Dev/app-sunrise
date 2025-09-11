<?php

namespace App\Enums;

enum ClientColumns: string
{
    case full_name = 'full_name';
    case dob = 'dob';
    case age = 'age';
    case ssn = 'ssn';
    case client_number = 'client_number';
    case howpa_client_number = 'howpa_client_number';
    case meal_client_number = 'meal_client_number';
    case effective_date = 'effective_date';
    case legal_status = 'legal_status';
    case identification_type = 'identification_type';
    case identification_number = 'identification_number';
    case identification_expiration_date = 'identification_expiration_date';
    case address_formatted = 'address_formatted';
    case city_district = 'city_district';
    case county_district = 'county_district';
    case city = 'city';
    case email = 'email';
    case income = 'income';
    case income_type = 'income_type';
    case gender = 'gender';
    case is_deceased = 'is_deceased';
    case ethnicity = 'ethnicity';
    case healthcare_provider = 'healthcare_provider';
    case healthcare_provider_plan = 'healthcare_provider_plan';
    case housing_status = 'housing_status';
    case income_category = 'income_category';

    public function label(): string
    {
        return match ($this) {
            self::full_name => 'Full Name',
            self::dob => 'Date of Birth',
            self::age => 'Age',
            self::ssn => 'SSN',
            self::client_number => 'Client #',
            self::howpa_client_number => 'HOPWA Client #',
            self::meal_client_number => 'Meal Client #',
            self::effective_date => 'Effective Date',
            self::legal_status => 'Legal Status',
            self::identification_type => 'ID Type',
            self::identification_number => 'ID Number',
            self::identification_expiration_date => 'ID Expiration',

            self::address_formatted => 'Address',
            self::city_district => 'City District',
            self::county_district => 'County District',
            self::city => 'City',
            self::email => 'Email',
            self::income_type => 'Income Type',
            self::income => 'Income',
            self::gender => 'Gender',
            self::is_deceased => 'Deceased',
            self::ethnicity => 'Ethnicity',
            self::healthcare_provider => 'Healthcare Provider',
            self::healthcare_provider_plan => 'Provider Plan',
            self::housing_status => 'Housing Status',
            self::income_category => 'Income Category',
        };
    }
    public function default(): bool
    {
        return in_array($this, [
            self::full_name,
            self::dob,
            self::client_number,
            self::email,
            self::income,
            self::is_deceased,
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
