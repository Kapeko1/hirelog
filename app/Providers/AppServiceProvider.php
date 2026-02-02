<?php

namespace App\Providers;

use App\Models\WorkApplication;
use App\Observers\WorkApplicationObserver;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
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
        // Register observers
        WorkApplication::observe(WorkApplicationObserver::class);

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['pl', 'en'])
                ->labels([
                    'pl' => 'Polski',
                    'en' => 'English',
                ]);
        });
    }
}
