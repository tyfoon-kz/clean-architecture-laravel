<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Jobs\RecalculateProductSearchIndex;
use App\Models\Product;
use App\Models\ProductAudit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class ProductApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $products = Product::query()
            ->with(['category', 'unit', 'supplier'])
            ->when(request('category_id'), fn ($query, $categoryId) => $query->where('category_id', $categoryId))
            ->when(request('q'), fn ($query, $search) => $query->where(function ($query) use ($search) {
                $query->where('sku', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(15);

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request): ProductResource
    {
        $product = Product::create($request->validated());

        ProductAudit::create([
            'product_id' => $product->id,
            'user_id' => $request->user()->id,
            'event' => 'created',
            'new_values' => $product->only(['sku', 'name', 'price', 'stock']),
        ]);

        RecalculateProductSearchIndex::dispatch($product->id);

        return ProductResource::make($product->load(['category', 'unit', 'supplier']));
    }

    public function show(Product $product): ProductResource
    {
        Gate::authorize('view', $product);

        return ProductResource::make($product->load(['category', 'unit', 'supplier']));
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $before = $product->only(['sku', 'name', 'price', 'stock']);
        $product->update($request->validated());

        ProductAudit::create([
            'product_id' => $product->id,
            'user_id' => $request->user()->id,
            'event' => 'updated',
            'old_values' => $before,
            'new_values' => $product->only(['sku', 'name', 'price', 'stock']),
        ]);

        RecalculateProductSearchIndex::dispatch($product->id);

        return ProductResource::make($product->load(['category', 'unit', 'supplier']));
    }

    public function destroy(Product $product): JsonResponse
    {
        Gate::authorize('delete', $product);
        $product->delete();

        return response()->json(status: 204);
    }
}
