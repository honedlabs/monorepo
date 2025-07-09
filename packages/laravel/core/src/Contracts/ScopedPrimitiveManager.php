<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

use Closure;
use Honed\Core\Primitive;

/**
 * @internal
 */
interface ScopedPrimitiveManager
{
    /**
     * Resolve the scoped primitive manager.
     */
    public static function resolve(): static;

    /**
     * Configure the primitive using a closure.
     *
     * @param  class-string  $primitive
     */
    public function configureUsing(string $primitive, Closure $modifyUsing): void;

    /**
     * Configure the primitive.
     */
    public function configure(Primitive $primitive, Closure $setUp): void;
}
