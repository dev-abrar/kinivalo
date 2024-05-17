<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Basic;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        $basic = cache()->remember('basic_data', now()->addHours(24), function () {
            return Basic::find(1);
        });
    
        View::composer('*', function ($view) use ($basic) {
            $view->with('basic', $basic);
        });
    
    }
}
