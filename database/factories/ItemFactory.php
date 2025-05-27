<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isFree = fake()->boolean(20);

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'city' => fake()->city(),
            'category' => fake()->word(),
            'is_free' => $isFree,
            'price' => $isFree ? null : fake()->randomFloat(2, 5, 500),
            'image' => fake()->imageUrl(),
            'created_at' => now(),
            'admin_whatsapp' => '2126' . fake()->randomNumber(8, true),
            'admin_email' => fake()->unique()->safeEmail(), 
        ];
    }
}
