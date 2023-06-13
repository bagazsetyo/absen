<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'bagas',
            'email' => 'bagas@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('bagas123'),
        ]);
        $user->assignRole(['superadmin', 'mahasiswa']);
    }
}
