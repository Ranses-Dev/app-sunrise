<?php

namespace Database\Seeders;

use App\Models\Role;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insertOrIgnore([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        Role::first()->syncPermissions(Permission::all()->pluck('name')->toArray());
    }
}
