<?php

declare(strict_types=1);

namespace Honed\Data\Contracts;

interface Defaultable
{
    /**
     * Get the defaults for the data.
     *
     * @return array<string, mixed>
     */
    public static function getDefaults(): array;
}
