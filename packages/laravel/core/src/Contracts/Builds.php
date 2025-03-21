<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
interface Builds
{
    /**
     * Define the database resource to use.
     * 
     * @return TBuilder|TModel|class-string<TModel>
     */
    public function for();
}
