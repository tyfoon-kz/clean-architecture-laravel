<?php

declare(strict_types=1);

namespace App\Application\Catalog\Nomenclature\Contracts;

interface NomenclatureImportReader
{
    public function read(string $path): iterable;
}
