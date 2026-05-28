<?php

declare(strict_types=1);

namespace App\Application\Catalog\Nomenclature\Dto;

final readonly class CreatedNomenclatureResult
{
    public function __construct(public string $id, public string $sku)
    {
    }
}
