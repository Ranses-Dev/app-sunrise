<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdentificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('identification_types')->insert([
            ['name' => 'Passport', 'description' => 'An official document issued by a government, certifying the holder\'s identity and citizenship.'],
            ['name' => 'Driver License', 'description' => 'An official document permitting a specific individual to operate one or more types of motorized vehicles.'],
            ['name' => 'Permanent Resident Card', 'description' => 'An identification card for permanent residents, allowing them to live and work in the country.'],
            ['name' => 'Employment Authorization', 'description' => 'A document that provides temporary authorization to work in the country.'],
        ]);

    }
}
