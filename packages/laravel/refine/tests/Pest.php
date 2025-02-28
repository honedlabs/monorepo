<?php

declare(strict_types=1);

use Honed\Refine\Tests\Stubs\Product;
use Honed\Refine\Tests\Stubs\Status;
use Honed\Refine\Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;

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

function generateRequest(string $param, mixed $value)
{
    return Request::create(
        \sprintf('?%s=%s', $param, $value)
    );
}
