<?php

namespace Tests\Feature;

use App\Jobs\RecalculateProductSearchIndex;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReferenceSolutionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_panel_requires_admin_user(): void
    {
        $operator = User::factory()->create(['is_admin' => false]);
        $admin = User::factory()->admin()->create();

        $this->actingAs($operator)->get('/admin')->assertForbidden();
        $this->actingAs($admin)->get('/admin')->assertOk();
    }

    public function test_product_api_validates_stores_audits_and_dispatches_queue_job(): void
    {
        Queue::fake();

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $unit = Unit::factory()->create();
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($admin)->postJson('/api/products', [
            'category_id' => $category->id,
            'unit_id' => $unit->id,
            'supplier_id' => $supplier->id,
            'sku' => 'SKU-REF-001',
            'name' => 'Reference product',
            'price' => 1250.50,
            'stock' => 10,
            'is_active' => true,
        ]);

        $response->assertCreated()->assertJsonPath('data.sku', 'SKU-REF-001');
        $this->assertDatabaseHas('products', ['sku' => 'SKU-REF-001']);
        $this->assertDatabaseHas('product_audits', ['event' => 'created']);
        Queue::assertPushed(RecalculateProductSearchIndex::class);
    }

    public function test_product_upload_uses_public_disk_and_validation(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $product = Product::factory()->create();

        $this->actingAs($admin)
            ->postJson("/api/products/{$product->id}/asset", [
                'file' => UploadedFile::fake()->image('product.png'),
            ])
            ->assertCreated()
            ->assertJsonStructure(['path', 'url']);

        Storage::disk('public')->assertExists($product->fresh()->image_path);
    }
}
