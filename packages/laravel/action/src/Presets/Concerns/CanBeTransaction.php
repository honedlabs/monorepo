<?php

namespace Honed\Action\Presets\Concerns;

use Illuminate\Support\Facades\DB;

trait CanBeTransaction
{
    /**
     * Determine whether to wrap the update in a database transaction.
     * 
     * @return bool
     */
    protected function isTransaction()
    {
        return true;
    }

    /**
     * Perform a database operation, possibly wrapped in a transaction and 
     * return the result.
     * 
     * @param  callback
     * @return mixed
     */
    protected function transact($callback)
    {
        if ($this->isTransaction()) {
            return DB::transaction($callback);
        }

        return $callback();
    }
}