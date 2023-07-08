<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!empty(Auth::user())){
            $roleUser = Auth::user()->getRoleNames();
            foreach($roleUser as $role){
                if($role == 'superadmin' || $role == 'admin'){
                    return $next($request);
                }
            }
        }
        
        return redirect()->route('mahasiswa.dashboard');
    }
}
