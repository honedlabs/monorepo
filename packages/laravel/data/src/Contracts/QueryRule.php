<?php

declare(strict_types=1);

namespace Honed\Data\Contracts;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
interface QueryRule
{
    /**
     * Get the query builder to utilise.
     * 
     * @return TBuilder
     */
    public function query(): Builder;
}