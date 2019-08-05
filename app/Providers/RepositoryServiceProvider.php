<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\OrderRepositoryInterface;
use App\Repositories\OrderRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    public function provides()
    {
        return [
            OrderRepositoryInterface::class
        ];
    }
}
