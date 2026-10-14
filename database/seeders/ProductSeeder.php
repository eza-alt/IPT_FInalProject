<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();

        $menu = [
            'Rice Meals' => [
                'Chicken Adobo with Rice' => 55.00,
                'Pork Sinigang with Rice' => 60.00,
                'Fried Chicken with Rice' => 65.00,
                'Beef Tapa with Egg and Rice' => 70.00,
            ],
            'Snacks' => [
                'French Fries' => 30.00,
                'Fish Balls' => 20.00,
                'Banana Cue' => 15.00,
                'Siomai (4 pcs)' => 35.00,
            ],
            'Sandwiches' => [
                'Ham and Cheese Sandwich' => 35.00,
                'Egg Sandwich' => 25.00,
                'Chicken Burger' => 50.00,
            ],
            'Beverages' => [
                'Bottled Water' => 15.00,
                'Orange Juice' => 25.00,
                'Chocolate Milk' => 30.00,
                'Iced Tea' => 20.00,
            ],
            'Desserts' => [
                'Leche Flan' => 30.00,
                'Cupcake' => 25.00,
                'Ube Halaya Cup' => 28.00,
            ],
        ];

        foreach ($menu as $categoryName => $items) {
            $category = Category::where('name', $categoryName)->firstOrFail();

            foreach ($items as $name => $price) {
                Product::factory()->create([
                    'category_id' => $category->id,
                    'supplier_id' => $suppliers->random()->id,
                    'name' => $name,
                    'price' => $price,
                    'stock' => fake()->numberBetween(5, 80),
                ]);
            }
        }
    }
}