<?php

declare(strict_types=1);

namespace Workbench\App\Pipes;

use Honed\Core\Pipe;
use Workbench\App\Classes\Component;

/**
 * @extends Pipe<\Workbench\App\Classes\Component>
 */
class SetMeta extends Pipe
{
    /**
     * Run the pipe logic.
     */
    public function run(Component $component): void
    {
        $component->meta([]);
    }
}
