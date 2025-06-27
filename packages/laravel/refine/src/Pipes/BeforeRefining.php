<?php

declare(strict_types=1);

namespace Honed\Refine\Pipes;

use Honed\Core\Pipe;

/**
 * @template TClass of \Honed\Refine\Refine
 *
 * @extends Pipe<TClass>
 */
class BeforeRefining extends Pipe
{
    /**
     * Run the before refining logic.
     */
    public function run(): void
    {
        $before = $this->instance->getBeforeCallback();

        $this->instance->evaluate($before);
    }
}
