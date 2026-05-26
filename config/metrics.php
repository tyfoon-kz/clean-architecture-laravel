<?php

return [
    'store' => env('METRICS_STORE', 'file'),
    'redis_key' => env('METRICS_REDIS_KEY', 'metrics:prometheus'),
];
