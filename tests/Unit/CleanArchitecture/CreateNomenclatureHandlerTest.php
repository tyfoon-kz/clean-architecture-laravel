<?php

declare(strict_types=1);

namespace Tests\Unit\CleanArchitecture;

use App\Application\Catalog\Nomenclature\Commands\CreateNomenclatureFromFilamentCommand;
use App\Application\Catalog\Nomenclature\Commands\CreateNomenclatureFromFilamentHandler;
use App\Application\Catalog\Nomenclature\Contracts\NomenclatureRepository;
use App\Domain\Catalog\Nomenclature\Nomenclature;
use PHPUnit\Framework\TestCase;

final class CreateNomenclatureHandlerTest extends TestCase
{
    public function test_handler_saves_nomenclature_through_contract(): void
    {
        $repository = new class implements NomenclatureRepository {
            public ?Nomenclature $saved = null;

            public function save(Nomenclature $nomenclature): void
            {
                $this->saved = $nomenclature;
            }
        };

        $handler = new CreateNomenclatureFromFilamentHandler($repository);
        $result = $handler->handle(new CreateNomenclatureFromFilamentCommand('Kitchen Mixer', 'MIX-100'));

        self::assertSame('MIX-100', $result->sku);
        self::assertNotNull($repository->saved);
    }
}
