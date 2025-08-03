<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foodCosts = [
            ['cost' => 2.50],
            ['cost' => 3.00],
            ['cost' => 3.50],
            ['cost' => 4.00],
            ['cost' => 4.50],
            ['cost' => 5.00],
        ];
        foreach ($foodCosts as $foodCost) {
            DB::table('food_costs')->insertOrIgnore($foodCost);
        }
    }
}
