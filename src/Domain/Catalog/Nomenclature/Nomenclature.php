<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Nomenclature;

final class Nomenclature
{
    public function __construct(
        public readonly NomenclatureId $id,
        public readonly NomenclatureName $name,
    ) {
    }
}
