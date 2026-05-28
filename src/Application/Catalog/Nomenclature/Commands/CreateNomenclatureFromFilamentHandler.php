<?php

declare(strict_types=1);

namespace App\Application\Catalog\Nomenclature\Commands;

final class CreateNomenclatureFromFilamentHandler
{
    public function handle(CreateNomenclatureFromFilamentCommand $command): string
    {
        return 'created-from-filament:'.$command->sku;
    }
}
