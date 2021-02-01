<?php

namespace App\Providers;

use App\Repositories\Impl\CategoryRepository;
use App\Repositories\Impl\ProductRepository;
use App\Repositories\ICategoryRepository;
use App\Repositories\IProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
