<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Angkatan;
use App\Policies\AngkatanPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Angkatan::class => AngkatanPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    
        Gate::policy(Angkatan::class, AngkatanPolicy::class);
    }
}
