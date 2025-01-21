<?php

declare(strict_types=1);

namespace Honed\Refining\Sorts;

use Illuminate\Database\Eloquent\Builder;

class CallbackSort extends Sort
{
    // use HasCallback;

    public function handle(Builder $builder, string $direction, string $property): void
    {
        $this->getCallback()($builder, $direction, $property);
    }
}
