<?php

declare(strict_types=1);

namespace App\Application\Catalog\Nomenclature\Queries;

final readonly class NomenclatureListItem
{
    public function __construct(public string $id, public string $name, public string $sku)
    {
    }
}
