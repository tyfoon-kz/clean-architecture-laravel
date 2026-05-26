<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app/Catalog',
    ])
    ->withPreparedSets(
        codeQuality: true,
        deadCode: true,
    );
