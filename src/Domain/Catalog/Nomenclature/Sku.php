<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Nomenclature;

final readonly class Sku
{
    public function __construct(public string $value)
    {
        if (! preg_match('/^[A-Z0-9][A-Z0-9-]{2,63}$/', $value)) {
            throw new \InvalidArgumentException('SKU must use uppercase letters, digits and dashes.');
        }
    }
}
