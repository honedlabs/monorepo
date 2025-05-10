<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait FiltersUndefined
{
    /**
     * Filter any potential undefined values from an array.
     * 
     * @param array<string, mixed> $array
     * @return array<string, mixed>
     */
    public function filterUndefined($array)
    {
        return \array_filter(
            $array,
            static fn ($value) => ! \is_null($value)
        );
    }
}
