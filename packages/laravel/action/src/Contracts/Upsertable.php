<?php

declare(strict_types=1);

namespace Honed\Action\Contracts;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * 
 * @extends \Honed\Action\Contracts\RequiresModel<TModel>
 */
interface Upsertable extends RequiresModel
{
    /**
     * Get the unique by columns for the upsert.
     *
     * @return array<int, string>
     */
    public function uniqueBy(): array;

    /**
     * Get the columns to update in the upsert.
     *
     * @return array<int, string>
     */
    public function update(): array;

}