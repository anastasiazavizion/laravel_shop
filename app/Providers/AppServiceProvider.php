<?php

namespace App\Providers;

use App\Http\Resources\CartItemsResource;
use App\Repositories\Contract\CategoryRepositoryContract;
use App\Repositories\CategoryRepository;
use App\Repositories\Contract\ImageRepositoryContract;
use App\Repositories\Contract\ProductRepositoryContract;
use App\Repositories\Contract\WishListRepositoryContract;
use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;
use App\Repositories\WishListRepository;
use App\Services\Contracts\FileServiceContract;
use App\Services\FileService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind(CategoryRepositoryContract::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(ImageRepositoryContract::class, ImageRepository::class);
        $this->app->bind(FileServiceContract::class, FileService::class);

        $this->app->bind(WishListRepositoryContract::class,
            WishListRepository::class);

        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
