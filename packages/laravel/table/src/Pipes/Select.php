<?php

declare(strict_types=1);

namespace Honed\Table\Pipes;

use Honed\Core\Pipe;

/**
 * @template TClass of \Honed\Table\Table
 *
 * @extends Pipe<TClass>
 */
class Select extends Pipe
{
    /**
     * Run the after refining logic.
     *
     * @param  TClass  $instance
     * @return void
     */
    public function run($instance)
    {
        if (! $instance->isSelectable()) {
            return;
        }

        //
    }
}
