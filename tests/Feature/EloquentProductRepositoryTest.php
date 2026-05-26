<?php

namespace Tests\Feature;

use App\Catalog\Infrastructure\Eloquent\EloquentProductRepository;
use App\Models\Attribute as CatalogAttribute;
use App\Models\AttributeGroup;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_repository_restores_required_attributes_and_typed_values_for_publication(): void
    {
        $category = Category::factory()->create();
        $unit = Unit::factory()->create();
        $supplier = Supplier::factory()->create();
        $group = AttributeGroup::create(['name' => 'Technical specifications', 'code' => 'technical-specifications']);
        $attribute = CatalogAttribute::create([
            'attribute_group_id' => $group->id,
            'name' => 'Power',
            'code' => 'power_watts',
            'type' => CatalogAttribute::TYPE_INTEGER,
        ]);
        CategoryAttribute::create([
            'category_id' => $category->id,
            'attribute_id' => $attribute->id,
            'is_required' => true,
            'is_filterable' => true,
        ]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'unit_id' => $unit->id,
            'supplier_id' => $supplier->id,
        ]);
        AttributeValue::create([
            'product_id' => $product->id,
            'attribute_id' => $attribute->id,
            'value_integer' => 1800,
        ]);

        $repository = new EloquentProductRepository;

        $required = $repository->requiredAttributesForProduct($product->id);
        $domainProduct = $repository->findForPublication($product->id);

        $this->assertSame(['power_watts'], $required->all());

        $domainProduct->publish($required);

        $this->assertSame('published', $domainProduct->status()->value);
    }
}
