<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    use HasFactory;

    protected $table = 'qrcode';

    protected $fillable = [
        'id_angkatan',
        'id_kelas',
        'id_matkul',
        'teachingId',
        'periodId',
        'date',
        'meetingTo',
        'tahun',
        'bulan',
        'tanggal',
        'jam',
        'menit',
        'detik',
        'uniqueCode',
        'nama'
    ];

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'id_angkatan', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    public function matkul()
    {
        return $this->belongsTo(Matkul::class, 'id_matkul', 'id');
    }
}
