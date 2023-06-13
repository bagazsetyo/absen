<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::findByName('superadmin');
        $role->givePermissionTo(['create', 'read', 'update', 'delete']);

        $role = Role::findByName('admin');
        $role->givePermissionTo(['create', 'read', 'update', 'delete']);

        $role = Role::findByName('mahasiswa');
        $role->givePermissionTo(['read']);

        $role = Role::findByName('dosen');
        $role->givePermissionTo(['read']);
    }
}
