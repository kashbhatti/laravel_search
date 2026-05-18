<?php

namespace App\Providers;

use App\Interfaces\SearchInterface;
use App\Repositories\SearchRepository;
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
        if (config('database.default', 'mysql') === 'mysql') {
            $this->app->bind(SearchInterface::class, SearchRepository::class);
        }
    }
}
