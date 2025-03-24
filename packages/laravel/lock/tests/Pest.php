<?php

declare(strict_types=1);

use Honed\Lock\Tests\Stubs\Product;
use Honed\Lock\Tests\Stubs\Status;
use Honed\Lock\Tests\TestCase;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Str;

uses(TestCase::class)->in(__DIR__);

function product(?string $name = null): Product
{
    return Product::create([
        'public_id' => Str::uuid(),
        'name' => $name ?? fake()->unique()->word(),
        'description' => fake()->sentence(),
        'price' => fake()->randomNumber(4),
        'best_seller' => fake()->boolean(),
        'status' => fake()->randomElement(Status::cases()),
        'created_at' => now()->subDays(fake()->randomNumber(2)),
    ]);
}

function user(): User
{
    return User::query()->create([
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => fake()->password(),
    ]);
}
