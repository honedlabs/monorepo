<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

use Honed\Action\Jobs\QueuedAction;
use Illuminate\Foundation\Bus\PendingDispatch;

/**
 * @phpstan-require-implements \Honed\Action\Contracts\Action
 */
trait Queueable
{
    /**
     * Handle the action on the queue.
     */
    public function queue(mixed ...$arguments): PendingDispatch
    {
        return QueuedAction::dispatch($this, ...$arguments);
    }
}
