<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttachmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attachment_types')->insert([
            ['name' => 'Green Card', 'description' => 'Permanent Resident Card'],
            ['name' => 'Passport', 'description' => 'Passport Document'],
            ['name' => 'Driver\'s License', 'description' => 'State-issued Driver\'s License'],
            ['name' => 'Social Security Card', 'description' => 'Social Security Number Card'],
            ['name' => 'Birth Certificate', 'description' => 'Official Birth Certificate'],
            ['name' => 'State ID', 'description' => 'State-issued Identification Card'],
            ['name' => 'Work Permit', 'description' => 'Employment Authorization Document'],
            ['name' => 'Visa', 'description' => 'United States Visa'],
            ['name' => 'Other', 'description' => 'Other Document Type'],
        ]);
    }
}
