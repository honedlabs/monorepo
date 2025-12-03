<?php

declare(strict_types=1);

namespace Honed\Data\Concerns;

use App\Generators\FakeGenerator;

/**
 * @phpstan-require-extends \Spatie\LaravelData\Data
 */
trait Fakeable
{
    /**
     * Generate a fake instance of the data.
     *
     * @param  array<string, mixed>  $attributes
     */
    public static function fake(array $attributes = []): static
    {
        return FakeGenerator::make(static::class, $attributes);
    }
}
