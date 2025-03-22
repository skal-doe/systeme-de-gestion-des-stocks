<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movement>
 */
class MovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['in', 'out']),
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'user_id' => User::factory(),
            'supplier_id' => Supplier::factory(),
            'reference' => $this->faker->uuid,
            'date' => $this->faker->dateTimeThisYear,
            'notes' => $this->faker->sentence,
        ];
    }
}
