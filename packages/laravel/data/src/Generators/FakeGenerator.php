<?php

declare(strict_types=1);

namespace App\Generators;

use Faker\Factory;
use Illuminate\Support\Testing\Fakes\Fake;

class FakeGenerator
{
    /**
     * The Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new FakeGenerator instance.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Create a new fake generator instance.
     *
     * @param  class-string<\Spatie\LaravelData\Data>  $class
     * @param  array<string, mixed>  $attributes
     */
    public static function make(string $class, array $attributes = []): static
    {
        return app(static::class)->attributes($attributes);
    }
}
