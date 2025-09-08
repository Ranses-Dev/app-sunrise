<?php

namespace Database\Seeders;

use App\Models\IncomeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incomeTypes = [
            'HA Wage',
            'Non-Wage Income',
            'Other Wages',
            'Pension',
            'Social Security',
            'SSI',
        ];
        foreach ($incomeTypes as $type) {
            IncomeType::createOrFirst([
                'name' => $type,
                'description' => null,
            ]);
        }
    }
}
