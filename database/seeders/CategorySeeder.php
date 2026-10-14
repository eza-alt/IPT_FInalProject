<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Rice Meals' => 'Hearty meals served with steamed rice.',
            'Snacks' => 'Quick bites for recess and break time.',
            'Sandwiches' => 'Freshly made sandwiches and burgers.',
            'Beverages' => 'Juices, softdrinks, water and milk.',
            'Desserts' => 'Sweet treats and pastries.',
        ];

        foreach ($categories as $name => $description) {
            Category::factory()->create([
                'name' => $name,
                'description' => $description,
            ]);
        }
    }
}