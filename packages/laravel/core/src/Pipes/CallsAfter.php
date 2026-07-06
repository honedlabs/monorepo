<?php

declare(strict_types=1);

namespace Honed\Core\Pipes;

use Honed\Core\Contracts\HooksIntoLifecycle;
use Honed\Core\Pipe;

/**
 * @extends Pipe<\Honed\Core\Primitive&\Honed\Core\Contracts\HooksIntoLifecycle>
 */
class CallsAfter extends Pipe
{
    /**
     * Run the pipe logic.
     */
    public function run(HooksIntoLifecycle $instance): void
    {
        $instance->callAfter();
    }
}
