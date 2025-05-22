<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Item;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'item_id' => Item::inRandomOrder()->first()->id ?? Item::factory(),
            'content' => fake()->sentence(),
            'rating' => fake()->numberBetween(1, 5),
            'created_at' => now(),
        ];
    }
}
