<?php

declare(strict_types=1);

namespace Workbench\App\Pipes;

use Honed\Core\Pipe;
use Workbench\App\Classes\Component;

/**
 * @extends Pipe<\Workbench\App\Classes\Component>
 */
class SetType extends Pipe
{
    /**
     * The count of the pipe.
     *
     * @var int
     */
    protected static $count = 0;

    /**
     * Reset the count of the pipe.
     *
     * @return void
     */
    public static function reset()
    {
        static::$count = 0;
    }

    /**
     * Run the pipe logic.
     */
    public function run(Component $component): void
    {
        $component->type('Pipeline '.static::$count++);
    }
}
