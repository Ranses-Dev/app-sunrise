<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            1 => [
                'name' => 'HOWPA',
                'branches' => [
                    ['name' => 'LONG TERM'],
                    ['name' => 'SHORT TERM'],
                    ['name' => 'INSP']
                ]
            ],
            2 => ['name' => 'INSPECTIONS', 'branches' => [
                ['name' => 'HOME', 'description' => 'AFFORDABILITY-FIRST TIME HOME BUYERS'],
                ['name' => 'CDBG', 'description' => 'SECTION 8 - MOD REHAB'],
                ['name' => 'HOPWA-Q', 'description' => 'QUALITY INSPECTIONS'],
                ['name' => 'HOPWA-S', 'description' => 'HOPWA S OUR CLIENTS']
            ]],
            3 => ['name' => 'MEALS', 'branches' => [
                ['name' => 'API'],
                ['name' => 'MIAMI GARDENS'],
                ['name' => 'PUBLIC SERVICE'],
                ['name' => 'OTHERS']
            ]],
            4 => ['name' => 'RENTAL', 'branches' => [
                ['name' => 'SRAP'],
                ['name' => 'OTHERS']
            ]],
        ];

        foreach ($programs as $id => $data) {
            DB::table('programs')->insert([
                'id' => $id,
                'name' => $data['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($data['branches'] as  $branchName) {
                DB::table('program_branches')->insert([
                    'program_id' => $id,
                    'name' => $branchName['name'],
                    'description' => $branchName['description'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
