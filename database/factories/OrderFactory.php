<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_name' => fake()->name(),
            'order_date' => fake()->dateTimeBetween('-14 days', 'now')->format('Y-m-d'),
            'status' => fake()->randomElement(Order::STATUSES),
            'total_amount' => 0,
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
        ];
    }
}