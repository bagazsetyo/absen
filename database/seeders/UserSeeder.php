<?php

namespace Database\Seeders;

use App\Models\Angkatan;
use App\Models\Kelas;
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
        $angkatan = Angkatan::create([
            'tahun' => '2022',
            'nama' => '09/2022',
        ]);

        $kelas = Kelas::create([
            'nama' => 'B - Teknik Informatika',
        ]);

        $user = User::create([
            'name' => 'bagas',
            'email' => 'bagas@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('bagas123'),
            'wa' => '081229094273',
            'npm' => '2113221069',
            'angkatan' => $angkatan->id,
            'kelas' => $kelas->id,
        ]);
        
        $user->assignRole(['superadmin', 'mahasiswa']);
    }
}
