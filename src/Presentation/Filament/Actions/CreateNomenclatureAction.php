<?php

declare(strict_types=1);

namespace App\Presentation\Filament\Actions;

use App\Application\Catalog\Nomenclature\Commands\CreateNomenclatureFromFilamentCommand;
use App\Application\Catalog\Nomenclature\Commands\CreateNomenclatureFromFilamentHandler;

final readonly class CreateNomenclatureAction
{
    public function __construct(private CreateNomenclatureFromFilamentHandler $handler)
    {
    }

    public function __invoke(array $data): string
    {
        $result = $this->handler->handle(new CreateNomenclatureFromFilamentCommand((string) $data['name'], (string) $data['sku']));

        return $result->id;
    }
}
