<?php

namespace App\Support\Runtime;

use RuntimeException;

final class TemporaryStreamExample
{
    public function run(bool $fail): array
    {
        $handle = fopen('php://temp', 'w+');

        if ($handle === false) {
            throw new RuntimeException('Unable to open temporary stream.');
        }

        try {
            fwrite($handle, 'runtime-cleanup-demo');

            if ($fail) {
                throw new RuntimeException('Intentional failure after opening stream.');
            }

            rewind($handle);

            return [
                'ok' => true,
                'contents' => stream_get_contents($handle),
                'closed_in_finally' => true,
            ];
        } finally {
            fclose($handle);
        }
    }
}
