<?php

namespace App\Providers;

use App\Repositories\AuthRepositoryInterface;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\Eloquent\AuthRepository;
use App\Repositories\Eloquent\BookRepository;
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

        $this->app->singleton(
            BookRepositoryInterface::class,
            BookRepository::class,
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
