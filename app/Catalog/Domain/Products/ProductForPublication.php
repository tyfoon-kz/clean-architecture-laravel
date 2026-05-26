<?php

namespace App\Catalog\Domain\Products;

final class ProductForPublication
{
    /**
     * @param  list<string>  $filledAttributeCodes
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        private ProductStatus $status,
        private array $filledAttributeCodes,
    ) {}

    public function publish(RequiredAttributes $requiredAttributes): void
    {
        $missing = $requiredAttributes->missingFrom($this->filledAttributeCodes);

        if ($missing !== []) {
            throw ProductCannotBePublished::missingRequiredAttributes($missing);
        }

        $this->status = ProductStatus::Published;
    }

    public function status(): ProductStatus
    {
        return $this->status;
    }
}
