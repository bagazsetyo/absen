<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'superadmin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'mahasiswa',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'dosen',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'ban',
            'guard_name' => 'web'
        ]);
    }
}
