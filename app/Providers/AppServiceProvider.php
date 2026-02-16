<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);

        // Set active role on login
        Auth::loginUsingId(1); // Only if needed for testing, skip in production

        Auth::viaRequest('web', function ($request) {
            if (Auth::check() && !Session::has('active_role')) {
                $user = Auth::user();

                $teacherRoles = ['Teacher', 'Assistant Professor', 'Associate Professor', 'Professor', 'Program Leader UG', 'Program Leader PG'];

                if ($user->roles()->whereIn('name', $teacherRoles)->exists()) {
                    Session::put('active_role', 'teacher');
                } elseif ($user->hasRole('HOD')) {
                    Session::put('active_role', 'hod');
                } else {
                    Session::put('active_role', $user->roles()->first()?->name ?? null);
                }
            }
        });

    }
}
