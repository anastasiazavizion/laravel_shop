<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Policies\Admin\CategoryPolicy;
use App\Policies\Admin\ProductPolicy;
use App\Repositories\CartRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Contract\CartRepositoryContract;
use App\Repositories\Contract\CategoryRepositoryContract;
use App\Repositories\Contract\ImageRepositoryContract;
use App\Repositories\Contract\OrderRepositoryContract;
use App\Repositories\Contract\ProductRepositoryContract;
use App\Repositories\Contract\WishListRepositoryContract;
use App\Repositories\ImageRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\WishListRepository;
use App\Services\CacheService;
use App\Services\Contracts\CacheServiceContract;
use App\Services\Contracts\FileServiceContract;
use App\Services\Contracts\InvoiceServiceContract;
use App\Services\Contracts\PayPalServiceContract;
use App\Services\FileService;
use App\Services\InvoiceService;
use App\Services\PayPalService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
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
        $this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(ImageRepositoryContract::class, ImageRepository::class);
        $this->app->bind(FileServiceContract::class, FileService::class);
        $this->app->bind(PayPalServiceContract::class, PayPalService::class);
        $this->app->bind(OrderRepositoryContract::class, OrderRepository::class);
        $this->app->bind(CartRepositoryContract::class, CartRepository::class);
        $this->app->bind(CacheServiceContract::class, CacheService::class);

        $this->app->bind(InvoiceServiceContract::class, InvoiceService::class);

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
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);

        JsonResource::withoutWrapping();

        Relation::enforceMorphMap([
            'product' => Product::class,
            'category' => Category::class,
            'App\Models\User' => User::class
        ]);

        if(env('APP_ENV') === 'production')
        {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
