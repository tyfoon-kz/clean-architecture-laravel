<?php

namespace App\Support\Runtime;

final class RequestStateLeakProbe
{
    private static ?string $lastMarker = null;

    public function rememberUnsafe(?string $marker): array
    {
        $before = self::$lastMarker;

        if ($marker !== null) {
            self::$lastMarker = $marker;
        }

        return [
            'mode' => 'unsafe_static_field',
            'before' => $before,
            'after' => self::$lastMarker,
            'pid' => getmypid(),
        ];
    }

    public function rememberSafely(?string $marker): array
    {
        return [
            'mode' => 'safe_request_local_value',
            'before' => null,
            'after' => $marker,
            'pid' => getmypid(),
        ];
    }

    public static function reset(): void
    {
        self::$lastMarker = null;
    }
}
