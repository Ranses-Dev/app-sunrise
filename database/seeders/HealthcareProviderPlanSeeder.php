<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HealthcareProviderPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = [
            ['name' => 'Obama Care'],
            ['name' => 'Leon'],
            ['name' => 'Preferred Care Partners'],
        ];
        foreach ($providers as $provider) {
            DB::table('healthcare_provider_plans')->insert($provider);
        }
    }
}
