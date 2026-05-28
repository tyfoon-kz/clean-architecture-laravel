<?php

declare(strict_types=1);

namespace Tests\Unit\CleanArchitecture;

use App\Domain\Catalog\Nomenclature\Sku;
use PHPUnit\Framework\TestCase;

final class NomenclatureDomainTest extends TestCase
{
    public function test_sku_rejects_invalid_value(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Sku('bad sku');
    }
}
