<?php

declare(strict_types=1);

namespace App\Application\Catalog\Nomenclature\Commands;

final readonly class CreateNomenclatureFromFilamentCommand
{
    public function __construct(
        public string $name,
        public string $sku,
        public array $attributes = [],
    ) {
    }
}
