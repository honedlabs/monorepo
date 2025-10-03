<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\ArrayFormatter;

/**
 * @extends Entry<array<int, mixed>|Collection<int, mixed>, array<int, mixed>|string>
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
