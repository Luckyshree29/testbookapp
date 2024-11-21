<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\BookFactoryInterface;
use App\Factories\BookFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // Binding the BookFactoryInterface to BookFactory
        $this->app->bind(BookFactoryInterface::class, BookFactory::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
