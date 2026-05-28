<?php

declare(strict_types=1);

namespace App\Application\Shared\Contracts;

interface TransactionRunner
{
    public function run(callable $callback): mixed;
}
