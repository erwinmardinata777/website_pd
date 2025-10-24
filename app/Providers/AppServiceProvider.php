<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ProfilWeb;
use App\Models\Visitor;

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
        // Share data to all views
        View::composer('*', function ($view) {
            // Ambil data profil dari database sekali saja
            $profilWeb = ProfilWeb::first();
            
            // Ambil statistik pengunjung
            $totalVisitors = Visitor::getTotalVisitors();
            $todayVisitors = Visitor::getTodayVisitors();
            $monthVisitors = Visitor::getMonthVisitors();
            
            // Share ke semua view
            $view->with([
                'profilWeb' => $profilWeb,
                'totalVisitors' => $totalVisitors,
                'todayVisitors' => $todayVisitors,
                'monthVisitors' => $monthVisitors,
            ]);
        });
    }
}
