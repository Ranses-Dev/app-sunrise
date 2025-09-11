<?php

namespace App\Enums;

enum HowpaContractColumns: string
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

    case phone_number                        = 'phone_number';
    case program_branch                      = 'program_branch';
    case date                                   = 'date';
    case re_certification_date                  = 're_certification_date';
    case client_service_specialist           = 'client_service_specialist';
    case number_bedrooms_req                    = 'number_bedrooms_req';
    case number_bedrooms_approved               = 'number_bedrooms_approved';
    case recent_living_situation                = 'recent_living_situation';
    case recent_living_situation_notes          = 'recent_living_situation_notes';
    case owns_real_estate                       = 'owns_real_estate';
    case own_any_stock_or_bonds                 = 'own_any_stock_or_bonds';
    case has_savings                            = 'has_savings';
    case savings_balance                        = 'savings_balance';
    case has_checking_account                   = 'has_checking_account';
    case checking_avg_balance_six_months        = 'checking_avg_balance_six_months';
    case assets_notes                           = 'assets_notes';
    case outside_support                        = 'outside_support';
    case outside_support_explanation            = 'outside_support_explanation';
    case committed_fraud_or_asked_to_repay      = 'committed_fraud_or_asked_to_repay';
    case fraud_explanation                      = 'fraud_explanation';
    case has_aids                               = 'has_aids';
    case howpa_prior_to_2023                    = 'howpa_prior_to_2023';
    case currently_receiving_other_aid          = 'currently_receiving_other_aid';
    case agreed_statements                      = 'agreed_statements';
    case emergency_contact_one               = 'emergency_contact_one';
    case emergency_contact_two               = 'emergency_contact_two';


    public function label(): string
    {
        return match ($this) {
            self::client_full_name                   => 'Client Full Name',
            self::client_address_formatted           => 'Client Address',
            self::client_dob                         => 'Client Date of Birth',
            self::client_ssn                         => 'Client SSN',
            self::client_effective_date              => 'Client Effective Date',
            self::client_meal_number                 => 'Client Meal #',
            self::client_legal_status                => 'Client Legal Status',
            self::client_identification_type         => 'Client ID Type',
            self::client_identification_number       => 'Client ID Number',
            self::client_identification_expiration_date => 'Client ID Expiration',
            self::client_city_district               => 'Client City District',
            self::client_county_district             => 'Client County District',
            self::client_city                        => 'Client City',
            self::client_email                       => 'Client Email',
            self::client_income                      => 'Client Income',
            self::client_income_type                 => 'Client Income Type',
            self::client_gender                      => 'Client Gender',
            self::client_is_deceased                 => 'Client Is Deceased',
            self::client_ethnicity                   => 'Client Ethnicity',
            self::client_healthcare_provider         => 'Client Healthcare Provider',
            self::client_healthcare_provider_plan    => 'Client Healthcare Provider Plan',
            self::client_housing_status              => 'Client Housing Status',
            self::client_income_category             => 'Client Income Category',

            self::phone_number                       => 'Phone Number',
            self::program_branch                     => 'Program Branch',
            self::date                               => 'Date',
            self::re_certification_date              => 'Re-Certification Date',
            self::client_service_specialist          => 'Service Specialist',
            self::number_bedrooms_req                => 'Bedrooms (Requested)',
            self::number_bedrooms_approved           => 'Bedrooms (Approved)',
            self::recent_living_situation            => 'Recent Living Situation',
            self::recent_living_situation_notes      => 'Living Situation Notes',
            self::owns_real_estate                   => 'Owns Real Estate',
            self::own_any_stock_or_bonds             => 'Owns Stocks/Bonds',
            self::has_savings                        => 'Has Savings',
            self::savings_balance                    => 'Savings Balance',
            self::has_checking_account               => 'Has Checking Account',
            self::checking_avg_balance_six_months    => 'Checking Avg Balance (6m)',
            self::assets_notes                       => 'Assets Notes',
            self::outside_support                    => 'Outside Support',
            self::outside_support_explanation        => 'Outside Support Explanation',
            self::committed_fraud_or_asked_to_repay  => 'Committed Fraud / Asked to Repay',
            self::fraud_explanation                  => 'Fraud Explanation',
            self::has_aids                           => 'Has AIDS',
            self::howpa_prior_to_2023                => 'HOWPA Prior to 2023',
            self::currently_receiving_other_aid      => 'Receiving Other Aid',
            self::agreed_statements                  => 'Agreed Statements',
            self::emergency_contact_one              => 'Emergency Contact 1',
            self::emergency_contact_two              => 'Emergency Contact 2',
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
            self::program_branch,
            self::date,
            self::re_certification_date,
            self::client_service_specialist,
            self::number_bedrooms_req,
            self::has_savings,
            self::has_checking_account,
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
