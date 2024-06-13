<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(100),
            'description' => $this->faker->text(255),
            'price' => $this->faker->numberBetween(1000, 5000),
            'category_id' => Category::factory()
        ];
    }
}
