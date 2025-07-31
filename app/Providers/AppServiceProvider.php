<?php

namespace App\Providers;

use App\Services\NotificationService;
use App\Services\SettingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(NotificationService::class, function ($app) {
            return new NotificationService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $view->with([
                'appName' => SettingService::get('app_name', 'Default'),
                'footerText' => SettingService::get('footer_text', 'Admin'),
                'appVersion' => SettingService::get('app_version', '0.0.0')
            ]);
        });
    }
}
