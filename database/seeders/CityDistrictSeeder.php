<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            'District #1',
            'District #2',
            'District #3',
            'District #4',
            'District #5',
        ];

        foreach ($districts as $district) {
            DB::table('city_districts')->insert([
                'name' => $district,

            ]);
        }
    }
}
