<?php

declare(strict_types=1);

namespace Honed\Binding;

abstract class Binder
{
    /**
     * The default namespace where binders reside.
     *
     * @var string
     */
    public static $namespace = 'Binders\\';
    
    /**
     * The binder name resolver.
     *
     * @var \Closure(string): string
     */
    protected static $binderNameResolver;

    public function has($field)
    {
        // Check the cache...?
    }
}