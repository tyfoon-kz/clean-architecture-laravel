<?php

declare(strict_types=1);

namespace App\Catalog\Application\Products;

use App\Catalog\Application\Support\TransactionManager;
use App\Catalog\Domain\Products\ProductRepository;

class PublishProductService
{
    public function __construct(
        private ProductRepository $products,
        private TransactionManager $transactions,
    ) {}

    public function handle(PublishProductCommand $command): void
    {
        $this->transactions->run(function () use ($command): void {
            $product = $this->products->findForPublication($command->productId);
            $requiredAttributes = $this->products->requiredAttributesForProduct($command->productId);

            $product->publish($requiredAttributes);

            $this->products->savePublished($product, $command->actorId);
        });
    }
}
