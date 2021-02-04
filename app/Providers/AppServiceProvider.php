<?php

namespace App\Providers;

use App\Services\ICategoryService;
use App\Services\Implement\CategoryService;
use App\Services\Implement\ProductService;
use App\Services\IProductService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->app->bind(IProductService::class, ProductService::class);
        $this->app->bind(ICategoryService::class, CategoryService::class);
    }
}
