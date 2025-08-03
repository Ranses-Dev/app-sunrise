<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HealthcareProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('healthcare_providers')->insert([
            ['name' => 'Medicaid'],
            ['name' => 'Medicare'],
            ['name' => 'HMO'],
            ['name' => 'Private'],
        ]);
    }
}
