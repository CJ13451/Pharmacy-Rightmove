<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('manage-listings', fn (User $user) => $user->role->canManageListings());
        Gate::define('manage-supplier-profile', fn (User $user) => $user->role->canManageSupplierProfile());
    }
}
