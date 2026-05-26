<?php

namespace Tests\Unit;

use App\Catalog\Application\Products\PublishProductCommand;
use App\Catalog\Application\Products\PublishProductService;
use App\Catalog\Application\Support\TransactionManager;
use App\Catalog\Domain\Products\ProductForPublication;
use App\Catalog\Domain\Products\ProductRepository;
use App\Catalog\Domain\Products\ProductStatus;
use App\Catalog\Domain\Products\RequiredAttributes;
use PHPUnit\Framework\TestCase;

class PublishProductServiceTest extends TestCase
{
    public function test_publish_product_service_uses_repository_contract(): void
    {
        $repository = new class implements ProductRepository
        {
            public ?ProductStatus $savedStatus = null;

            public ?int $actorId = null;

            public function findForPublication(int $productId): ProductForPublication
            {
                return new ProductForPublication(
                    id: $productId,
                    name: 'Frost 3000 Refrigerator',
                    status: ProductStatus::Draft,
                    filledAttributeCodes: ['volume_liters', 'energy_class'],
                );
            }

            public function requiredAttributesForProduct(int $productId): RequiredAttributes
            {
                return RequiredAttributes::fromCodes(['volume_liters', 'energy_class']);
            }

            public function savePublished(ProductForPublication $product, int $actorId): void
            {
                $this->savedStatus = $product->status();
                $this->actorId = $actorId;
            }
        };
        $transactions = new class implements TransactionManager
        {
            public bool $wasCalled = false;

            public function run(callable $callback): mixed
            {
                $this->wasCalled = true;

                return $callback();
            }
        };

        $service = new PublishProductService($repository, $transactions);

        $service->handle(new PublishProductCommand(productId: 15, actorId: 7));

        $this->assertSame(ProductStatus::Published, $repository->savedStatus);
        $this->assertSame(7, $repository->actorId);
        $this->assertTrue($transactions->wasCalled);
    }
}
