<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genders')->insert([
            ['name' => 'Male','code'=>'M'],
            ['name' => 'Female','code'=>'F'],
            ['name' => 'Transgender Male To Female','code'=>'TF'],
            ['name' => 'Transgender Female To Male','code'=>'TM']
        ]);
    }
}
