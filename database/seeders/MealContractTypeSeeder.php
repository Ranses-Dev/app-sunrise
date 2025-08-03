<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mealContractTypes = [
            ['name' => 'API'],
            ['name' => 'Public Service'],
            ['name' => 'MIAMI GARDENS'],
        ];

        foreach ($mealContractTypes as $type) {
            DB::table('meal_contract_types')->updateOrInsert(
                ['name' => $type['name']],
                $type
            );
        }
    }
}
