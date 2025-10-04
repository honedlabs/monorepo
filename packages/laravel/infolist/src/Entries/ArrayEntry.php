<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\ArrayFormatter;

/**
 * @extends Entry<array<int, mixed>|\Illuminate\Support\Collection<int, mixed>, array<int, mixed>|string>
 *
 * @method $this pluck(string $value) Set the property to pluck from the array.
 * @method string|null getPluck() Get the property to pluck from the array.
 * @method $this glue(string $value = ', ') Set the separator to use when joining the array.
 * @method string|null getGlue() Get the separator to use when joining the array.
 */
class ArrayEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('array');

        $this->formatter(ArrayFormatter::class);
    }
}
