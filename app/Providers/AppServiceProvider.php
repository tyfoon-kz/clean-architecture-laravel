<?php

namespace App\Providers;

use App\Catalog\Application\Support\TransactionManager;
use App\Catalog\Domain\Products\ProductRepository;
use App\Catalog\Infrastructure\Eloquent\EloquentProductRepository;
use App\Catalog\Infrastructure\Laravel\LaravelTransactionManager;
use App\Support\Runtime\RequestContext;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(TransactionManager::class, LaravelTransactionManager::class);
        $this->app->scoped(RequestContext::class, fn () => new RequestContext);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('products-api', function (Request $request) {
            return Limit::perMinute(30)->by($request->user()?->id ?: $request->ip());
        });
    }
}
