<?php

declare(strict_types=1);

namespace App\Application\Catalog\Nomenclature\Commands;

use App\Application\Catalog\Nomenclature\Contracts\NomenclatureRepository;
use App\Application\Catalog\Nomenclature\Dto\CreatedNomenclatureResult;
use App\Domain\Catalog\Nomenclature\Nomenclature;
use App\Domain\Catalog\Nomenclature\NomenclatureId;
use App\Domain\Catalog\Nomenclature\NomenclatureName;
use App\Domain\Catalog\Nomenclature\Sku;

final readonly class CreateNomenclatureFromFilamentHandler
{
    public function __construct(private NomenclatureRepository $repository)
    {
    }

    public function handle(CreateNomenclatureFromFilamentCommand $command): CreatedNomenclatureResult
    {
        $sku = new Sku($command->sku);
        $id = new NomenclatureId('nom_'.strtolower(str_replace('-', '_', $sku->value)));

        $this->repository->save(new Nomenclature($id, new NomenclatureName($command->name)));

        return new CreatedNomenclatureResult($id->value, $sku->value);
    }
}
