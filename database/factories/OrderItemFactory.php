<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::factory(),
            'product_id' => \App\Models\Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'total' => $this->faker->randomFloat(2, 1, 1000),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'declined']),
            'payment_status' => $this->faker->randomElement(['pending', 'completed', 'declined']),
            'shipping_status' => $this->faker->randomElement(['pending', 'completed', 'declined']),

        ];
    }
}
