<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers;

use App\Application\Catalog\Nomenclature\Commands\CreateNomenclatureFromFilamentCommand;
use App\Application\Catalog\Nomenclature\Commands\CreateNomenclatureFromFilamentHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final readonly class CreateNomenclatureController
{
    public function __construct(private CreateNomenclatureFromFilamentHandler $handler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->handle(new CreateNomenclatureFromFilamentCommand((string) $request->input('name'), (string) $request->input('sku')));

        return new JsonResponse(['id' => $result->id, 'sku' => $result->sku], 201);
    }
}
