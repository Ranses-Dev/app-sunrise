<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveryCosts = [
            ['cost' => 0.00],
            ['cost' => 1.00],
            ['cost' => 2.00],
            ['cost' => 3.00],
            ['cost' => 4.00],
            ['cost' => 5.00],
            ['cost' => 6.00],
            ['cost' => 7.00],
            ['cost' => 8.00],
            ['cost' => 9.00],
            ['cost' => 10.00],
        ];

        foreach ($deliveryCosts as $deliveryCost) {
            DB::table('delivery_costs')->updateOrInsert(
                ['cost' => $deliveryCost['cost']],
                $deliveryCost
            );
        }
    }
}
