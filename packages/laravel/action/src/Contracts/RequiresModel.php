<?php

declare(strict_types=1);

namespace Honed\Action\Contracts;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
interface RequiresModel
{
    /**
     * Get the model to store the input data in.
     *
     * @return class-string<TModel>
     */
    public function for(): string;
}