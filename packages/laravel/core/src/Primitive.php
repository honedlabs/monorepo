<?php

declare(strict_types=1);

namespace Honed\Core;

use BadMethodCallException;
use Honed\Core\Concerns\Configurable;
use Honed\Core\Concerns\Definable;
use Honed\Core\Concerns\Evaluable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

/**
 * @template TKey of array-key = string
 * @template TValue of mixed = mixed
 *
 * @extends SimplePrimitive<TKey,TValue>
 */
abstract class Primitive extends SimplePrimitive
{
    use Conditionable;
    use Configurable;
    use Definable;
    use Evaluable;
    use Macroable {
        __call as macroCall;
    }
    use Tappable;

    /**
     * Construct the instance.
     */
    public function __construct()
    {
        $this->configure();
    }

    /**
     * Handle dynamic method calls into the method.
     *
     * @param  string  $method
     * @param  array<int,mixed>  $parameters
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        return $this->macroCall($method, $parameters);
    }
}
