<?php

namespace App\Providers;


use Hashids\Hashids;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();

        $this->app->singleton('hashid', function () {
            return new Hashids('LaravelStartup', 10);
        });
    }
}
