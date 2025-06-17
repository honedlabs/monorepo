<?php

declare(strict_types=1);

namespace Honed\Core;

use BadMethodCallException;
use Honed\Core\Concerns\Configurable;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Contracts\NullsAsUndefined;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use JsonSerializable;

use function array_filter;

/**
 * @template TKey of array-key = string
 * @template TValue of mixed = mixed
 *
 * @implements Arrayable<TKey,TValue>
 */
abstract class Primitive implements Arrayable, JsonSerializable
{
    use Conditionable;
    use Configurable;
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
        $this->setUp();
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

    /**
     * Serialize the instance
     *
     * @return array<string,mixed>
     */
    public function jsonSerialize(): mixed
    {
        if ($this instanceof NullsAsUndefined) {
            return array_filter(
                $this->toArray(),
                static fn ($value) => ! is_null($value)
            );
        }

        return $this->toArray();
    }
}
