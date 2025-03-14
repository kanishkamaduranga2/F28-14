<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LanguageService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LanguageService::class, function () {
            return new LanguageService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
