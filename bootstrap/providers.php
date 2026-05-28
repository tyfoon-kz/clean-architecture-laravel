<?php

use App\Providers\AppServiceProvider;
use App\Providers\CleanArchitectureServiceProvider;
use App\Providers\Filament\AdminPanelProvider;

return [
    AppServiceProvider::class,
    CleanArchitectureServiceProvider::class,
    AdminPanelProvider::class,
];
