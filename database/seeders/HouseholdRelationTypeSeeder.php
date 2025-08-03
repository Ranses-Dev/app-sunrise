<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HouseholdRelationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('household_relation_types')->insert([
            ['name' => 'Head of Household'],
            ['name' => 'Spouse'],
            ['name' => 'Child'],
            ['name' => 'Parent'],
            ['name' => 'Sibling'],
            ['name' => 'Grandparent'],
            ['name' => 'Grandchild'],
            ['name' => 'Other Relative'],
            ['name' => 'Non-relative'],
        ]);
    }
}
