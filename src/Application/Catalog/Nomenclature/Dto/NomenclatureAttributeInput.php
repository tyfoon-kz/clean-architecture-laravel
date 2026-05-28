<?php

declare(strict_types=1);

namespace App\Application\Catalog\Nomenclature\Dto;

final readonly class NomenclatureAttributeInput
{
    public function __construct(public string $code, public string $value)
    {
    }
}
