<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'contact_person' => fake()->name(),
            'phone' => fake()->numerify('09#########'),
            'email' => fake()->unique()->companyEmail(),
            'address' => fake()->address(),
        ];
    }
}