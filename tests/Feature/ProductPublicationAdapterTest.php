<?php

namespace Tests\Feature;

use App\Models\Attribute as CatalogAttribute;
use App\Models\AttributeGroup;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPublicationAdapterTest extends TestCase
{
    use RefreshDatabase;

    public function test_http_adapter_rejects_publication_when_required_attribute_is_missing(): void
    {
        $admin = User::factory()->admin()->create();
        [$product] = $this->productWithRequiredAttributes(filled: false);

        $this->actingAs($admin)
            ->postJson("/api/products/{$product->id}/publish")
            ->assertUnprocessable()
            ->assertJsonPath('code', 'product_cannot_be_published');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'status' => 'draft',
        ]);
    }

    public function test_http_adapter_publishes_product_through_use_case(): void
    {
        $admin = User::factory()->admin()->create();
        [$product] = $this->productWithRequiredAttributes(filled: true);

        $this->actingAs($admin)
            ->postJson("/api/products/{$product->id}/publish")
            ->assertOk()
            ->assertJsonPath('status', 'published');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'status' => 'published',
        ]);
        $this->assertDatabaseHas('product_audits', [
            'product_id' => $product->id,
            'user_id' => $admin->id,
            'event' => 'published',
        ]);
    }

    /**
     * @return array{0: Product, 1: CatalogAttribute}
     */
    private function productWithRequiredAttributes(bool $filled): array
    {
        $category = Category::factory()->create();
        $unit = Unit::factory()->create();
        $supplier = Supplier::factory()->create();
        $group = AttributeGroup::create([
            'name' => 'Technical specifications',
            'code' => 'technical-specifications',
        ]);
        $attribute = CatalogAttribute::create([
            'attribute_group_id' => $group->id,
            'name' => 'Volume',
            'code' => 'volume_liters',
            'type' => CatalogAttribute::TYPE_DECIMAL,
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
            'status' => 'draft',
        ]);

        if ($filled) {
            AttributeValue::create([
                'product_id' => $product->id,
                'attribute_id' => $attribute->id,
                'value_decimal' => 320,
            ]);
        }

        return [$product, $attribute];
    }
}
