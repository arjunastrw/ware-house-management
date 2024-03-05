<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;

use Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            $user = auth()->user(); // Assuming you are using authentication
            $view->with('loggedInUser', $user);
        });
    }
}
