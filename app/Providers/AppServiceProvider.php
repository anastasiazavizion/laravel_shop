<?php

namespace App\Providers;

use App\Repositories\Contract\CategoryRepositoryContract;
use App\Repositories\CategoryRepository;
use App\Repositories\Contract\ImageRepositoryContract;
use App\Repositories\ImageRepository;
use App\Services\Contracts\FileServiceContract;
use App\Services\FileService;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(ImageRepositoryContract::class, ImageRepository::class);
        $this->app->bind(FileServiceContract::class, FileService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
