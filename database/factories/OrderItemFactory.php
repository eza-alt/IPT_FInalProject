<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'quantity' => fake()->numberBetween(1, 4),
            'unit_price' => fn (array $attributes) => Product::find($attributes['product_id'])->price,
            'subtotal' => fn (array $attributes) => Product::find($attributes['product_id'])->price * $attributes['quantity'],
        ];
    }

    public function forProduct(Product $product, int $quantity = 1): static
    {
        return $this->state(fn () => [
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);
    }
}