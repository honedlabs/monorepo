<?php

declare(strict_types=1);

namespace Honed\Core\Pipes;

use Honed\Core\Pipe;

/**
 * @template TClass of \Honed\Core\Contracts\HooksIntoLifecycle
 *
 * @extends Pipe<TClass>
 */
class CallsBefore extends Pipe
{
    /**
     * Run the pipe logic.
     */
    public function run(): void
    {
        $this->getInstance()->callBefore();
    }
}
