<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'declined']),
            'total' => $this->faker->randomFloat(2, 1, 1000),
            'payment_method' => $this->faker->randomElement(['cash', 'credit_card', 'paypal']),
            'payment_status' => $this->faker->randomElement(['pending', 'completed', 'declined']),
            'shipping_method' => $this->faker->randomElement(['pickup', 'delivery']),
            'shipping_status' => $this->faker->randomElement(['pending', 'completed', 'declined']),
            'shipping_address' => $this->faker->address(),
            'shipping_city' => $this->faker->city(),
            'shipping_country' => $this->faker->country(),
            'shipping_county' => $this->faker->city(),
        ];
    }
}
