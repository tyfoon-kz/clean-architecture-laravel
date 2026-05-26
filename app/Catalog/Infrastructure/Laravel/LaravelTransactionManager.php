<?php

namespace App\Catalog\Infrastructure\Laravel;

use App\Catalog\Application\Support\TransactionManager;
use Illuminate\Support\Facades\DB;

class LaravelTransactionManager implements TransactionManager
{
    public function run(callable $callback): mixed
    {
        return DB::transaction($callback);
    }
}
