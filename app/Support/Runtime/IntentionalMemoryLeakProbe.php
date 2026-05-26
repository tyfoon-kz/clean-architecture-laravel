<?php

namespace App\Support\Runtime;

final class IntentionalMemoryLeakProbe
{
    /**
     * Intentional local/testing demo. Do not keep request payloads like this.
     *
     * @var list<string>
     */
    private static array $payloads = [];

    public function grow(int $kilobytes): array
    {
        $kilobytes = max(1, min($kilobytes, 1024));
        self::$payloads[] = str_repeat('x', $kilobytes * 1024);

        return [
            'items_retained' => count(self::$payloads),
            'memory_usage_bytes' => memory_get_usage(true),
            'memory_peak_bytes' => memory_get_peak_usage(true),
            'pid' => getmypid(),
        ];
    }

    public static function reset(): void
    {
        self::$payloads = [];
    }
}
