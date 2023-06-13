<?php

namespace App\Policies;

use App\Models\Angkatan;
use App\Models\User;

class AngkatanPolicy
{   
    public function add(User $user): bool
    {
        dd($user->roles()->with('permissions')->get());
        return true;
    }
}
