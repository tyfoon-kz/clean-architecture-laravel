<?php

namespace App\Support\Runtime;

use Illuminate\Support\Str;

final class RequestContext
{
    private string $requestId;

    public function __construct()
    {
        $this->requestId = (string) Str::uuid();
    }

    public function requestId(): string
    {
        return $this->requestId;
    }
}
