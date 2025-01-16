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
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'stock' => $this->faker->numberBetween(1, 100),
            'quantity' => $this->faker->numberBetween(1, 100),
            'sku' => $this->faker->unique()->ean8(),
            'image_url' => 'https://picsum.photos/id/' . $this->faker->numberBetween(0, 100) . '/200/300',
            'category_id' => rand(1, Category::count()),
            'type' => ProductType::factory(),
            'status' => 'active'
            ];
    }
}
