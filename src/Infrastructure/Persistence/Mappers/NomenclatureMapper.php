<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Mappers;

use App\Domain\Catalog\Nomenclature\Nomenclature;
use App\Domain\Catalog\Nomenclature\NomenclatureId;
use App\Domain\Catalog\Nomenclature\NomenclatureName;
use App\Models\Product;

final class NomenclatureMapper
{
    public function toDomain(Product $product): Nomenclature
    {
        return new Nomenclature(new NomenclatureId((string) $product->getKey()), new NomenclatureName((string) $product->name));
    }
}
