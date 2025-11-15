<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support\Utility;

use Honed\Scaffold\Concerns\Writable;

class Writer
{
    use Writable;

    /**
     * Create a new writer instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }
}
