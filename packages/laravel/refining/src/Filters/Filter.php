<?php

declare(strict_types=1);

namespace Honed\Refining\Filters;

use Honed\Refining\Refiner;
use Honed\Core\Concerns\Validatable;
use Illuminate\Contracts\Database\Query\Builder;

class Filter extends Refiner
{
    use Validatable;
    
    public function apply(Builder $builder): void
    {
        $builder->when(
            $this->isActive() && $this->validate($value),
            fn (Builder $builder) => $builder->where($this->getAttribute(), $value)
        );
    }

    public function isActive(): bool
    {
        return $this->hasValue();
    }

}
