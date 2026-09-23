<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Profile;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {}

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('components.consultation-modal', function ($view) {
            $view->with('products', Product::latest()->active()->get());
        });

        View::composer('frontend.*', function ($view) {
            $view->with('profile', Profile::first());
        });

        Paginator::useBootstrap();
    }
}
