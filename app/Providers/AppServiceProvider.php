<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProfilWeb;
use Illuminate\Support\Facades\View;

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
        // Ambil data profil dari database sekali saja
        View::composer('*', function ($view) {
            $ProfilWeb = ProfilWeb::first();
            $view->with('profilWeb', $ProfilWeb);
        });
    }
}
