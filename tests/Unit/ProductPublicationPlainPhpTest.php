<?php

namespace Tests\Unit;

use App\Catalog\Domain\Products\ProductCannotBePublished;
use App\Catalog\Domain\Products\ProductForPublication;
use App\Catalog\Domain\Products\ProductStatus;
use App\Catalog\Domain\Products\RequiredAttributes;
use PHPUnit\Framework\TestCase;

class ProductPublicationPlainPhpTest extends TestCase
{
    public function test_plain_php_product_rejects_publication_when_required_attribute_is_missing(): void
    {
        $product = new ProductForPublication(
            id: 101,
            name: 'Steel 1700 Kettle',
            status: ProductStatus::Draft,
            filledAttributeCodes: ['power_watts'],
        );

        $this->expectException(ProductCannotBePublished::class);

        $product->publish(RequiredAttributes::fromCodes(['power_watts', 'volume_liters']));
    }

    public function test_plain_php_product_accepts_publication_when_required_attributes_are_filled(): void
    {
        $product = new ProductForPublication(
            id: 101,
            name: 'Steel 1700 Kettle',
            status: ProductStatus::Draft,
            filledAttributeCodes: ['power_watts', 'volume_liters'],
        );

        $product->publish(RequiredAttributes::fromCodes(['power_watts', 'volume_liters']));

        $this->assertSame(ProductStatus::Published, $product->status());
    }
}
