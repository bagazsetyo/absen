<?php

namespace App\Policies;

use App\Models\Angkatan;
use App\Models\User;

class AngkatanPolicy
{   
    public function index(User $user): bool
    {
        // ambil nama function ini 
        // dd(__FUNCTION__);
        // lihat sedang nama controller yang diakses 
        dd(request()->route()->getControllerClass());
        return true;
    }

    public function add(User $user): bool
    {
        dd(request()->route()->getControllerClass(), request()->route()->getActionMethod());
        return true;
        dd($user->roles()->with('permissions')->get());
        return true;
    }
}
