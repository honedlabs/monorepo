<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\Status;
use App\Models\Product;
use App\Models\User;

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
            'public_id' => Str::uuid()->toString(),
            'user_id' => User::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(100, 1000),
            'best_seller' => fake()->boolean(),
            'status' => fake()->randomElement(Status::cases()),
            'created_at' => now()->subDays(fake()->numberBetween(16, 30)),
            'updated_at' => now()->subDays(fake()->numberBetween(1, 15)),
        ];
    }
}