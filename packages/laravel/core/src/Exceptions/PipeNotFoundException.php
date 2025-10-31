<?php

declare(strict_types=1);

namespace Honed\Core\Exceptions;

use Exception;

class PipeNotFoundException extends Exception
{
    /**
     * Create a new exception.
     *
     * @param  class-string<\Honed\Core\Pipe>  $pipe
     */
    final public function __construct(string $pipe)
    {
        parent::__construct(
            sprintf('The pipe [%s] could not be found within the pipeline.', $pipe)
        );
    }

    /**
     * Throw the exception.
     *
     * @param  class-string<\Honed\Core\Pipe>  $pipe
     *
     * @throws self
     */
    public static function throw(string $pipe): never
    {
        throw new self($pipe);
    }
}
