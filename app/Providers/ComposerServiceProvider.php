<?php

namespace App\Providers;

use App\Views\Composers\FooterComposer;
use Illuminate\Support\ServiceProvider;
use App\Views\Composers\NavigationComposer;


class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // if(env('APP_DEBUG')) {
        //     $this->app['config']->set('debugbar.enabled', true);
        //     $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        //     \Debugbar::enable();
        // }
        // $this->app->singleton(AboutComposer::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('frontend.layouts.sidebar', NavigationComposer::class);
        view()->composer('frontend.layouts.footer', FooterComposer::class);
    }
}
