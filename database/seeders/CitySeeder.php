<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Miami',
            'Homestead',
            'Florida City',
            'Miami Beach',
            'Coral Gables',
            'Hialeah',
            'North Miami',
            'Opa-locka',
            'Miami Springs',
            'South Miami',
            'Golden Beach',
            'North Miami Beach',
            'Miami Shores',
            'Biscayne Park',
            'Surfside',
            'El Portal',
            'Indian Creek Village',
            'Sweetwater',
            'North Bay Village',
            'West Miami',
            'Bay Harbor Islands',
            'Bal Harbour',
            'Virginia Gardens',
            'Hialeah Gardens',
            'Medley',
            'Key Biscayne',
            'Aventura',
            'Pinecrest',
            'Sunny Isles Beach',
            'Miami Lakes',
            'Palmetto Bay',
            'Miami Gardens',
            'Doral',
            'Cutler Bay',
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'name' => $city,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
