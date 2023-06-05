<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->load_twilio();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share('STRIPE_KEY', env('STRIPE_KEY'));
        Inertia::share('MAP_KEY', env('GOOGLE_MAP_API'));
    }
    private function load_twilio(){
        require_once( app_path('Libraries/twilio_sdk/autoload.php'));
    }
}
