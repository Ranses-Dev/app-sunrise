<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramDeliveryCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveryCosts = [
            ['cost' => 5.00],
            ['cost' => 7.50],
            ['cost' => 10.00],
            ['cost' => 12.50],
            ['cost' => 15.00],
        ];

        foreach ($deliveryCosts as $deliveryCost) {
            DB::table('program_delivery_costs')->insertOrIgnore([
                'cost' => $deliveryCost['cost']
            ]);
        }
    }
}
