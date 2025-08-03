<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EthnicitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ethnicities = [
            'WHITE',
            'BLACK/AFRICAN AMERICAN',
            'BLACK/AFRICAN AMERICAN/WHITE',
            'ASIAN',
            'ASIAN WHITE',
            'AMERICAN INDIAN/ALASKAN NATIVE',
            'AMERICAN INDIAN/ALASKAN NATIVE/WHITE',
            'AMERICAN INDIAN/ALASKA NATIVE/BLACK/AFRICAN AMERICAN',
            'NATIVE HAWAIIAN/PACIFIC ISLANDER',
            'OTHER/MULTI-RACIAL',
        ];

        foreach ($ethnicities as $ethnicity) {
            DB::table('ethnicities')->insert([
                'name' => $ethnicity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
