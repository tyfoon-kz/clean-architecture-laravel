<?php

namespace Tests\Unit;

use App\Catalog\Domain\Products\ProductCannotBePublished;
use App\Catalog\Domain\Products\ProductForPublication;
use App\Catalog\Domain\Products\ProductStatus;
use App\Catalog\Domain\Products\RequiredAttributes;
use PHPUnit\Framework\TestCase;

class ProductPublicationRuleTest extends TestCase
{
    public function test_product_cannot_be_published_without_required_attributes(): void
    {
        $product = new ProductForPublication(
            id: 15,
            name: 'Frost 3000 Refrigerator',
            status: ProductStatus::Draft,
            filledAttributeCodes: ['volume_liters'],
        );

        $this->expectException(ProductCannotBePublished::class);

        $product->publish(RequiredAttributes::fromCodes(['volume_liters', 'energy_class']));
    }

    public function test_product_with_required_attributes_can_be_published(): void
    {
        $product = new ProductForPublication(
            id: 15,
            name: 'Frost 3000 Refrigerator',
            status: ProductStatus::Draft,
            filledAttributeCodes: ['volume_liters', 'energy_class'],
        );

        $product->publish(RequiredAttributes::fromCodes(['volume_liters', 'energy_class']));

        $this->assertSame(ProductStatus::Published, $product->status());
    }
}
