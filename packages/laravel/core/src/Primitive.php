<?php

declare(strict_types=1);

namespace Honed\Core;

use Honed\Core\Contracts\Makeable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

/**
 * @template TKey of string
 * @template TValue of mixed
 *
 * @implements Arrayable<TKey,TValue>
 */
abstract class Primitive implements \JsonSerializable, Arrayable, Makeable
{
    use Concerns\Evaluable;
    use Conditionable;
    use ForwardsCalls;
    use Macroable {
        __call as macroCall;
    }
    use Tappable;

    /**
     * Construct the instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setUp();
    }

    /**
     * Serialize the instance
     *
     * @return array<mixed>
     */
    public function jsonSerialize(): mixed
    {
        return \array_filter(
            $this->toArray(),
            static fn ($value) => ! empty($value)
        );
    }

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    public function setUp()
    {
        //
    }

    /**
     * Handle dynamic method calls into the method.
     *
     * @param  string  $method
     * @param  array<int,mixed>  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        static::throwBadMethodCallException($method);
    }
}
