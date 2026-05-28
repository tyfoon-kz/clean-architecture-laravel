<?php

declare(strict_types=1);

namespace App\Domain\Catalog\ProductAttributes;

use App\Domain\Catalog\Nomenclature\NomenclatureAttributeSet;

final class NomenclatureAttributePolicy
{
    public function assertRequiredAttributesPresent(NomenclatureAttributeSet $set, array $requiredCodes): void
    {
        foreach ($requiredCodes as $code) {
            if (! array_key_exists($code, $set->values)) {
                throw new \InvalidArgumentException(sprintf('Required attribute "%s" is missing.', $code));
            }
        }
    }
}
