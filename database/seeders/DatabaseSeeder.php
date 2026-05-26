<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        User::factory()->create([
            'name' => 'Operator User',
            'email' => 'operator@example.com',
            'password' => 'password',
        ]);

        $categories = Category::factory(6)->create();
        $units = Unit::factory(4)->create();
        $suppliers = Supplier::factory(5)->create();

        Product::factory(50)->create([
            'category_id' => fn () => $categories->random()->id,
            'unit_id' => fn () => $units->random()->id,
            'supplier_id' => fn () => $suppliers->random()->id,
        ]);

        $specs = AttributeGroup::create([
            'name' => 'Technical specifications',
            'code' => 'technical-specifications',
            'sort_order' => 10,
        ]);

        $volume = Attribute::create([
            'attribute_group_id' => $specs->id,
            'name' => 'Volume',
            'code' => 'volume_liters',
            'type' => Attribute::TYPE_DECIMAL,
            'sort_order' => 10,
        ]);
        $energyClass = Attribute::create([
            'attribute_group_id' => $specs->id,
            'name' => 'Energy class',
            'code' => 'energy_class',
            'type' => Attribute::TYPE_STRING,
            'sort_order' => 20,
        ]);
        $power = Attribute::create([
            'attribute_group_id' => $specs->id,
            'name' => 'Power',
            'code' => 'power_watts',
            'type' => Attribute::TYPE_INTEGER,
            'sort_order' => 30,
        ]);
        $autoShutOff = Attribute::create([
            'attribute_group_id' => $specs->id,
            'name' => 'Auto shut-off',
            'code' => 'auto_shut_off',
            'type' => Attribute::TYPE_BOOLEAN,
            'sort_order' => 40,
        ]);
        $cleaningType = Attribute::create([
            'attribute_group_id' => $specs->id,
            'name' => 'Cleaning type',
            'code' => 'cleaning_type',
            'type' => Attribute::TYPE_STRING,
            'sort_order' => 50,
        ]);
        $suctionPower = Attribute::create([
            'attribute_group_id' => $specs->id,
            'name' => 'Suction power',
            'code' => 'suction_power_watts',
            'type' => Attribute::TYPE_INTEGER,
            'sort_order' => 60,
        ]);

        $refrigerators = Category::factory()->create(['name' => 'Refrigerators', 'slug' => 'refrigerators']);
        $kettles = Category::factory()->create(['name' => 'Kettles', 'slug' => 'kettles']);
        $vacuumCleaners = Category::factory()->create(['name' => 'Vacuum cleaners', 'slug' => 'vacuum-cleaners']);

        foreach ([[$refrigerators, $volume, true, true, 10], [$refrigerators, $energyClass, true, true, 20]] as [$category, $attribute, $required, $filterable, $order]) {
            CategoryAttribute::create([
                'category_id' => $category->id,
                'attribute_id' => $attribute->id,
                'is_required' => $required,
                'is_filterable' => $filterable,
                'sort_order' => $order,
            ]);
        }

        foreach ([[$kettles, $power, true, true, 10], [$kettles, $volume, true, true, 20], [$kettles, $autoShutOff, false, true, 30]] as [$category, $attribute, $required, $filterable, $order]) {
            CategoryAttribute::create([
                'category_id' => $category->id,
                'attribute_id' => $attribute->id,
                'is_required' => $required,
                'is_filterable' => $filterable,
                'sort_order' => $order,
            ]);
        }

        foreach ([[$vacuumCleaners, $cleaningType, true, true, 10], [$vacuumCleaners, $suctionPower, true, true, 20]] as [$category, $attribute, $required, $filterable, $order]) {
            CategoryAttribute::create([
                'category_id' => $category->id,
                'attribute_id' => $attribute->id,
                'is_required' => $required,
                'is_filterable' => $filterable,
                'sort_order' => $order,
            ]);
        }

        $refrigerator = Product::factory()->create([
            'category_id' => $refrigerators->id,
            'unit_id' => $units->first()->id,
            'supplier_id' => $suppliers->first()->id,
            'sku' => 'FRIDGE-FROST-3000',
            'name' => 'Frost 3000 Refrigerator',
        ]);
        AttributeValue::create(['product_id' => $refrigerator->id, 'attribute_id' => $volume->id, 'value_decimal' => 320]);
        AttributeValue::create(['product_id' => $refrigerator->id, 'attribute_id' => $energyClass->id, 'value_string' => 'A++']);

        $kettle = Product::factory()->create([
            'category_id' => $kettles->id,
            'unit_id' => $units->first()->id,
            'supplier_id' => $suppliers->first()->id,
            'sku' => 'KETTLE-STEEL-1700',
            'name' => 'Steel 1700 Kettle',
        ]);
        AttributeValue::create(['product_id' => $kettle->id, 'attribute_id' => $power->id, 'value_integer' => 1800]);
        AttributeValue::create(['product_id' => $kettle->id, 'attribute_id' => $volume->id, 'value_decimal' => 1.7]);

        $vacuumCleaner = Product::factory()->create([
            'category_id' => $vacuumCleaners->id,
            'unit_id' => $units->first()->id,
            'supplier_id' => $suppliers->first()->id,
            'sku' => 'VACUUM-DRY-450',
            'name' => 'Dry 450 Vacuum Cleaner',
        ]);
        AttributeValue::create(['product_id' => $vacuumCleaner->id, 'attribute_id' => $cleaningType->id, 'value_string' => 'dry']);
        AttributeValue::create(['product_id' => $vacuumCleaner->id, 'attribute_id' => $suctionPower->id, 'value_integer' => 450]);
    }
}
