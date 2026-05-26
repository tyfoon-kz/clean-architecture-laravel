<?php

namespace App\Catalog\Infrastructure\Eloquent;

use App\Catalog\Domain\Products\ProductForPublication;
use App\Catalog\Domain\Products\ProductRepository;
use App\Catalog\Domain\Products\ProductStatus;
use App\Catalog\Domain\Products\RequiredAttributes;
use App\Models\Product;
use App\Models\ProductAudit;

class EloquentProductRepository implements ProductRepository
{
    public function findForPublication(int $productId): ProductForPublication
    {
        $product = Product::query()
            ->with(['attributeValues.attribute'])
            ->findOrFail($productId);

        $filledAttributeCodes = $product->attributeValues
            ->filter(fn ($value) => $value->hasFilledValue())
            ->map(fn ($value) => $value->attribute?->code)
            ->filter()
            ->values()
            ->all();

        return new ProductForPublication(
            id: $product->id,
            name: $product->name,
            status: ProductStatus::tryFrom($product->status) ?? ProductStatus::Draft,
            filledAttributeCodes: $filledAttributeCodes,
        );
    }

    public function requiredAttributesForProduct(int $productId): RequiredAttributes
    {
        $product = Product::query()
            ->with(['category.categoryAttributes.attribute'])
            ->findOrFail($productId);

        $requiredCodes = $product->category?->categoryAttributes
            ->where('is_required', true)
            ->map(fn ($categoryAttribute) => $categoryAttribute->attribute?->code)
            ->filter()
            ->values()
            ->all() ?? [];

        return RequiredAttributes::fromCodes($requiredCodes);
    }

    public function savePublished(ProductForPublication $product, int $actorId): void
    {
        $record = Product::query()->findOrFail($product->id);
        $oldStatus = $record->status;

        $record->forceFill([
            'status' => $product->status()->value,
            'is_active' => true,
        ])->save();

        ProductAudit::create([
            'product_id' => $record->id,
            'user_id' => $actorId,
            'event' => 'published',
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $product->status()->value],
        ]);
    }
}
