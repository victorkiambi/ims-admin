<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'cost' => $cost = $this->faker->randomFloat(2, 1, 1000),
            'price' => $this->faker->randomFloat(2, $cost + 1, $cost + 1000),
            'code' => $this->faker->numberBetween(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'image_url' => 'https://picsum.photos/id/' . $this->faker->numberBetween(0, 100) . '/200/300',
            'category_id' => rand(1, Category::count()),
            'type' => ProductType::factory(),
            ];
    }
}
