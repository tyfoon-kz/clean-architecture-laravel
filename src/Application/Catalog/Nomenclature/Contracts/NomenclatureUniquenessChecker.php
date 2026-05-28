<?php

declare(strict_types=1);

namespace App\Application\Catalog\Nomenclature\Contracts;

use App\Domain\Catalog\Nomenclature\Sku;

interface NomenclatureUniquenessChecker
{
    public function existsBySku(Sku $sku): bool;
}
