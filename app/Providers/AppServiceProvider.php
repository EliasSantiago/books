<?php

namespace App\Providers;

use App\Repositories\AuthRepositoryInterface;
use App\Repositories\Eloquent\AuthRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            AuthRepositoryInterface::class,
            AuthRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
