<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Honed\Core\Tests\TestCase;
use Honed\Core\Tests\Stubs\Product;

uses(TestCase::class)->in(__DIR__);

function product(?string $name = null): Product
{
    return Product::factory()->create([
        'public_id' => Str::uuid(),
        'name' => $name ?? fake()->unique()->word(),
        'description' => fake()->sentence(),
        'price' => fake()->randomNumber(4),
        'best_seller' => fake()->boolean(),
        'status' => fake()->randomElement(Status::cases()),
        'created_at' => now()->subDays(fake()->randomNumber(2)),
    ]);
}
