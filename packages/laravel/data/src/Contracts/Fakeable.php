<?php

declare(strict_types=1);

namespace Honed\Data\Contracts;

interface Fakeable
{
    /**
     * Generate a fake instance of the data.
     *
     * @param  array<string, mixed>  $attributes
     */
    public static function fake(array $attributes = []): static;
}