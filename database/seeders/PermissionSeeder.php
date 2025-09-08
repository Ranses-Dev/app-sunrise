<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'Attachment Type',
            'City',
            'City District',
            'Client',
            'Client File',
            'Client Phone Number',
            'Contract Meal',
            'County District',
            'Ethnicity',
            'Gender',
            'Healthcare Provider',
            'Healthcare Provider Plan',
            'Household Member',
            'Household Relation Type',
            'Identification Type',
            'Income Limit',
            'Legal Status',
            'Monthly Assistance Payment',
            'Program',
            'Program Branch',
            'Role',
            'User',
            'Howpa Contract',
            'Emergency Contact',
            'Housing Status',
            'Inspection Type',
            'Housing Type',
            'Inspection',
            'Address',
            'Income Type',
        ];
        $actions = ['view any', 'view', 'create', 'update', 'delete', 'restore', 'force delete'];
        foreach ($models as $model) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => Str::slug("{$action} {$model}"),
                    'guard_name' => 'web',
                ]);
            }
        }
    }
}
