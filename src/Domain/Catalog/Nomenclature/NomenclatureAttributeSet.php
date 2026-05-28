<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Nomenclature;

final readonly class NomenclatureAttributeSet
{
    public function __construct(public array $values)
    {
    }
}
