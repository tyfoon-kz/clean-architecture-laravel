<?php

declare(strict_types=1);

namespace App\Application\Catalog\Nomenclature\Contracts;

use App\Domain\Catalog\Nomenclature\Nomenclature;

interface NomenclatureRepository
{
    public function save(Nomenclature $nomenclature): void;
}
