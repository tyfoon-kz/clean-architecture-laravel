<?php

declare(strict_types=1);

namespace App\Application\Catalog\Nomenclature\Queries;

final readonly class GetNomenclatureListQuery
{
    public function __construct(public int $limit = 50)
    {
    }
}
