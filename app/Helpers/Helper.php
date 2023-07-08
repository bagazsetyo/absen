<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Helper {
    
    public static function listHari()
    {
        return [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => "Jum'at",
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
    }

    public static function getHariByDate($date)
    {
        $hari = date('N', strtotime($date));
        return self::listHari()[$hari];
    }

    public static function isAdmin()
    {
        $auth = Auth::user();
        $hasRole = $auth->hasRole('superadmin') || $auth->hasRole('admin');

        return $hasRole;
    }

}