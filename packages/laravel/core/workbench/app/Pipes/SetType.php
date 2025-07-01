<?php

declare(strict_types=1);

namespace Workbench\App\Pipes;

use Honed\Core\Pipe;

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
    public function run(): void
    {
        $this->instance->type('Pipeline '.static::$count++);
    }
}
