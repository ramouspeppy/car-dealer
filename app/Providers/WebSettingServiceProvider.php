<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\WebSetting;

class WebSettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (App::runningInConsole()) return;

        $this->loadSettings();
    }

    /**
     * Load settings dari cache atau database,
     * lalu share ke config dan semua view.
     */
    private function loadSettings(): void
    {
        try {
            $settings = Cache::rememberForever('settings', function () {
                return WebSetting::pluck('value', 'name')->toArray();
            });

            // ✅ Akses via config('settings.key') di controller & blade
            config()->set('settings', $settings);

            // ✅ Akses via $settings['key'] langsung di semua blade
            View::share('settings', $settings);
        } catch (\Exception $e) {
            // Jika DB belum siap (misal saat migrate pertama)
            // aplikasi tetap jalan tanpa crash
            config()->set('settings', []);
            View::share('settings', []);
        }
    }
}
