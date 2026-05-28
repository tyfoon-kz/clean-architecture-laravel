<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Application\Catalog\Nomenclature\Contracts\NomenclatureRepository;
use App\Domain\Catalog\Nomenclature\Nomenclature;
use App\Models\Product;

final class EloquentNomenclatureRepository implements NomenclatureRepository
{
    public function save(Nomenclature $nomenclature): void
    {
        Product::query()->updateOrCreate(['name' => $nomenclature->name->value], ['name' => $nomenclature->name->value]);
    }
}
