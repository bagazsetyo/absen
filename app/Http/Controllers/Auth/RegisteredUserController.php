<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    protected $role = 'mahasiswa';
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $angkatan = Angkatan::all();
        $kelas = Kelas::all();
        return view('auth.register')->with([
            'angkatan' => $angkatan,
            'kelas' => $kelas,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'wa' => ['required', 'string', 'max:255', 'unique:users'],
            'npm' => ['required', 'string', 'max:255', 'unique:users'],
            'angkatan' => ['required'],
            'kelas' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'wa' => $request->wa,
            'npm' => $request->npm,
            'angkatan' => $request->angkatan,
            'kelas' => $request->kelas,
        ]);

        $user->assignRole($this->role);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
