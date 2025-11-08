<?php

declare(strict_types=1);

namespace Honed\Form\Exceptions;

use Exception;

class CannotResolveGenerator extends Exception
{
    /**
     * Create a new exception.
     * 
     * @param  class-string<\Spatie\LaravelData\Data|\Illuminate\Http\Request>  $className
     */
    final public function __construct(string $className)
    {
        parent::__construct(
            "Could not resolve a form generator for [{$className}]."
        );
    }

    /**
     * Throw the exception.
     *
     * @param  class-string<\Spatie\LaravelData\Data|\Illuminate\Http\Request>  $className
     * 
     * @throws self
     */
    public static function throw(string $className): never
    {
        throw new self($className);
    }
}
