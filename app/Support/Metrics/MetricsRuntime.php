<?php

namespace App\Support\Metrics;

class MetricsRuntime
{
    private static ?float $startedAt = null;

    public static function startedAt(): float
    {
        self::$startedAt ??= microtime(true);

        return self::$startedAt;
    }

    public static function uptimeSeconds(): float
    {
        return microtime(true) - self::startedAt();
    }
}
