<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class RecalculateProductSearchIndex implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $productId) {}

    public function handle(): void
    {
        $product = Product::find($this->productId);

        if (! $product) {
            return;
        }

        $product->forceFill(['search_indexed_at' => now()])->save();

        Log::info('Product search index recalculated', [
            'product_id' => $product->id,
            'sku' => $product->sku,
        ]);
    }
}
