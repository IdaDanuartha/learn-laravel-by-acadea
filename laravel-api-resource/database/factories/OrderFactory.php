<?php

namespace Database\Factories;

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
            'product_id' => fake()->numberBetween(1,100),
            'user_id' => fake()->numberBetween(1,10),
            'price' => fake()->numberBetween(10000, 100000),
            'qty' => fake()->numberBetween(1, 100)
        ];
    }
}
