<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Nomenclature;

final readonly class NomenclatureId
{
    public function __construct(public string $value)
    {
        if ($value === '') {
            throw new \InvalidArgumentException('Nomenclature id must not be empty.');
        }
    }
}
