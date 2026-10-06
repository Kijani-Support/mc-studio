<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set up main warehouse

        $warehouse = Warehouse::factory()->state([
            'name' => 'Main Warehouse',
            'description' => 'This is the main warehouse',
        ])->create();

        // Create brand

        Brand::factory()
                ->has(Product::factory()->state([
                    'warehouse_id' => $warehouse->id
                ])->count(5))
                ->count(5)->create();

        Category::factory(5)->create();
    }
}
