<?php

namespace Database\Seeders;

use App\Models\HousingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HousingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $housingTypes = [
            ['name' => 'Single Family Detached'],
            ['name' => 'Duplex or Two Family'],
            ['name' => 'Row House or Town House'],
            ['name' => 'Low Rise: 3,4 Stories, Including Garden Apartment'],
            ['name' => 'High Rise: 5 or More Stories'],
            ['name' => 'Cooperative'],
            ['name' => 'Single Room Occupancy'],
            ['name' => 'Other'],
        ];
        foreach ($housingTypes as $type) {
            HousingType::firstOrCreate($type);
        }
    }
}
