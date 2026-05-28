<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

final class CleanArchitectureServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            \App\Application\Catalog\Nomenclature\Contracts\NomenclatureRepository::class,
            \App\Infrastructure\Persistence\Eloquent\Repositories\EloquentNomenclatureRepository::class,
        );
    }
}
