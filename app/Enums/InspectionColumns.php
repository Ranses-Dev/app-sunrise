<?php

namespace App\Enums;

enum InspectionColumns: string
{
    case program_branch = 'program_branch';
    case address = 'address';
    case inspection_requested_date = 'inspection_requested_date';
    case inspection_requested_incomplete = 'inspection_requested_incomplete';
    case inspection_requested_incomplete_notes = 'inspection_requested_incomplete_notes';
    case inspection_requested_not_scheduled = 'inspection_requested_not_scheduled';
    case inspection_requested_not_scheduled_notes = 'inspection_requested_not_scheduled_notes';
    case inspection_requested_scheduled_date = 'inspection_requested_scheduled_date';
    case landlord_name = 'landlord_name';
    case landlord_contact_information = 'landlord_contact_information';
    case landlord_address = 'landlord_address';
    case landlord_howpa = 'landlord_howpa';
    case tenant_name = 'tenant_name';
    case tenant_howpa = 'tenant_howpa';
    case tenant_contact_information = 'tenant_contact_information';
    case tenant_address = 'tenant_address';
    case housing_type = 'housing_type';
    case number_of_bedrooms = 'number_of_bedrooms';
    case housing_inspector = 'housing_inspector';
    case inspection_status = 'inspection_status';

    public function label(): string
    {
        return match ($this) {
            self::program_branch => 'Program Branch',
            self::address => 'Address',
            self::inspection_requested_date => 'Inspection Requested Date',
            self::inspection_requested_incomplete => 'Requested Incomplete',
            self::inspection_requested_incomplete_notes => 'Incomplete Notes',
            self::inspection_requested_not_scheduled => 'Requested Not Scheduled',
            self::inspection_requested_not_scheduled_notes => 'Not Scheduled Notes',
            self::inspection_requested_scheduled_date => 'Scheduled Date',
            self::landlord_name => 'Landlord Name',
            self::landlord_contact_information => 'Landlord Contact',
            self::landlord_address => 'Landlord Address',
            self::landlord_howpa => 'Landlord HOWPA Client',
            self::tenant_name => 'Tenant Name',
            self::tenant_howpa => 'Tenant HOWPA Client',
            self::tenant_contact_information => 'Tenant Contact',
            self::tenant_address => 'Tenant Address',
            self::housing_type => 'Housing Type',
            self::number_of_bedrooms => 'Bedrooms',
            self::housing_inspector => 'Housing Inspector',
            self::inspection_status => 'Inspection Status',
        };
    }
    public function default(): bool
    {
        return in_array($this, [
            self::program_branch,
            self::address,
            self::inspection_requested_date,
            self::landlord_name,
            self::tenant_name,
            self::inspection_status,
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
