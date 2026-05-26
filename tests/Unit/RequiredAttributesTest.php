<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Catalog\Domain\Products\RequiredAttributes;
use PHPUnit\Framework\TestCase;

class RequiredAttributesTest extends TestCase
{
    public function test_missing_attributes_are_reported_without_duplicates(): void
    {
        $required = RequiredAttributes::fromCodes([
            'volume_liters',
            'energy_class',
            'volume_liters',
        ]);

        $missing = $required->missingFrom([
            'volume_liters',
            'volume_liters',
        ]);

        $this->assertSame(['energy_class'], $missing);
    }
}
