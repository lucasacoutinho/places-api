<?php

namespace App\Providers;

use App\Repository\Eloquent\PlaceRepository;
use App\Repository\PlaceRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PlaceRepositoryInterface::class,
            PlaceRepository::class,
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
