<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

final class CleanArchitectureServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bindings are added when infrastructure adapters appear.
    }
}
