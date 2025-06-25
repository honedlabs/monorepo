<?php

namespace Honed\Core\Contracts;

use Closure;
use Honed\Core\Primitive;

interface ScopedPrimitiveManager
{
    /**
     * Resolve the scoped primitive manager.
     * 
     * @return static
     */
    public static function resolve(): static;

    /**
     * Configure the primitive using a closure.
     * 
     * @template T of \Honed\Core\Primitive
     * 
     * @param  class-string<T>  $component
     * @param  (\Closure(T):mixed|void)  $modifyUsing
     * @return void
     */
    public function configureUsing(string $component, Closure $modifyUsing): void;

    /**
     * Configure the primitive.
     * 
     * @param  \Honed\Core\Primitive  $component
     * @param  \Closure  $setUp
     * @return void
     */
    public function configure(Primitive $component, Closure $setUp): void;
}