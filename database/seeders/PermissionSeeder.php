<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'create',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'read',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'update',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'delete',
            'guard_name' => 'web'
        ]);
    }
}
