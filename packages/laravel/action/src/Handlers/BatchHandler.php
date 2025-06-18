<?php

declare(strict_types=1);

namespace Honed\Action\Handlers;

/**
 * @template TClass of \Honed\Action\Batch
 */
class BatchHandler extends Handler
{
    /**
     * Get the key to use for selecting records.
     *
     * @return string
     */
    protected function getKey() {}

    /**
     * Get the operations to be used to resolve the action.
     *
     * @return array<int,Operation>
     */
    protected function getOperations()
    {
        return $this->instance->getOperations();
    }

    protected function getBuilder()
    {
        return $this->instance->getBuilder();
    }
}
