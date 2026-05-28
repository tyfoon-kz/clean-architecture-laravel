<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Nomenclature;

final readonly class NomenclatureName
{
    public function __construct(public string $value)
    {
        if (trim($value) === '') {
            throw new \InvalidArgumentException('Nomenclature name must not be empty.');
        }
    }
}
