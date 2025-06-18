<?php

declare(strict_types=1);

namespace Workbench\App\Processes;

use Honed\Action\Process;
use Workbench\App\Actions\Product\StoreProduct;
use Workbench\App\Actions\Product\DispatchProductCreated;

/**
 * @template TPayload
 * @template TResult
 *
 * @extends Honed\Command\Process<TPayload, TResult>
 */
class ProductProcess extends Process
{
    /**
     * Indicate whether to wrap the callback in a database transaction.
     *
     * @var bool
     */
    protected static $transaction = true;

    /**
     * The tasks to be sequentially executed.
     *
     * @return array<int, class-string|\Closure>
     */
    protected function tasks()
    {
        return [
            StoreProduct::class,
            DispatchProductCreated::class,
        ];
    }
}
