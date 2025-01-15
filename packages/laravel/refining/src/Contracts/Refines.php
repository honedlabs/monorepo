<?php

namespace Honed\Refining\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Refines
{
    public function apply(Builder $builder);

    public function isActive(): bool;
}
