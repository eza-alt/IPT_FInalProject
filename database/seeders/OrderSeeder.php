<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        Order::factory()->count(15)->create()->each(function (Order $order) use ($products) {
            foreach ($products->random(fake()->numberBetween(1, 4)) as $product) {
                OrderItem::factory()
                    ->for($order)
                    ->forProduct($product, fake()->numberBetween(1, 3))
                    ->create();
            }

            $order->recalculateTotal();
        });
    }
}