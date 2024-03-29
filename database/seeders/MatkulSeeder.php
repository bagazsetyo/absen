<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Matkul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas = Kelas::first();
        $array = [
            [
                'nama' => 'Organisasi dan Arsitektur Komputer',
                'kode' => 'ARKOM_1',
                'jadwal' => '2023-07-10',
                'jam_mulai' => '18:30',
                'jam_selesai' => '21:00',
                'id_kelas' => $kelas->id,
            ],
            [
                'nama' => 'Aljabar Linear',
                'kode' => 'ALJABAR_1',
                'jadwal' => '2023-07-11',
                'jam_mulai' => '18:30',
                'jam_selesai' => '21:00',
                'id_kelas' => $kelas->id,
            ],
            [
                'nama' => 'Organisasi dan Arsitektur Komputer',
                'kode' => 'ARKOM_2',
                'jadwal' => '2023-07-13',
                'jam_mulai' => '18:30',
                'jam_selesai' => '21:00',
                'id_kelas' => $kelas->id,
            ],
            [
                'nama' => 'Aljabar Linear',
                'kode' => 'ALJABAR_2',
                'jadwal' => '2023-07-14',
                'jam_mulai' => '18:30',
                'jam_selesai' => '21:00',
                'id_kelas' => $kelas->id,
            ],
            [
                'nama' => 'Etika dan Kepribadian Profesi',
                'kode' => 'EKP_1',
                'jadwal' => '2023-07-15',
                'jam_mulai' => '14:10',
                'jam_selesai' => '15:30',
                'id_kelas' => $kelas->id,
            ],
            [
                'nama' => 'Etika dan Kepribadian Profesi',
                'kode' => 'EKP_2',
                'jadwal' => '2023-07-15',
                'jam_mulai' => '15:30',
                'jam_selesai' => '17:10',
                'id_kelas' => $kelas->id,
            ],
        ];

        foreach ($array as $item) {
            Matkul::create($item);
        }
    }
}
