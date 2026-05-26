<?php

namespace App\Support\Runtime;

final class WorkerMemoryCounter
{
    private static int $requests = 0;

    /**
     * This is an intentional runtime demo. Do not store request data like this.
     */
    public function increment(string $label): array
    {
        self::$requests++;

        return [
            'label' => $label,
            'requests_seen_by_this_php_process' => self::$requests,
            'pid' => getmypid(),
        ];
    }

    public static function reset(): void
    {
        self::$requests = 0;
    }
}
