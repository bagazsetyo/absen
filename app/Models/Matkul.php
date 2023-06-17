<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;

    protected $table = 'matkul';

    protected $fillable = [
        'nama',
        'kode',
        'jadwal',
        'jam_mulai',
        'jam_selesai',
    ];

}
