<?php

declare(strict_types=1);

namespace App\Infrastructure\Import;

use App\Application\Catalog\Nomenclature\Contracts\NomenclatureImportReader;

final class CsvNomenclatureImportReader implements NomenclatureImportReader
{
    public function read(string $path): iterable
    {
        if (! is_file($path)) {
            return [];
        }

        return [];
    }
}
