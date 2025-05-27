<?php

namespace Honed\Core;

use BadMethodCallException;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Contracts\WithoutNullValues;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use JsonSerializable;

use function array_filter;

abstract class Primitive implements JsonSerializable
{
    use Conditionable;
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
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    public function setUp()
    {
        //
    }

    /**
     * Get the instance as an array.
     *
     * @param  array<string,mixed>  $named
     * @param  array<class-string,mixed>  $typed
     * @return array<string,mixed>
     */
    abstract public function toArray($named = [], $typed = []);

    /**
     * Serialize the instance
     *
     * @return array<string,mixed>
     */
    public function jsonSerialize(): mixed
    {
        $array = $this->toArray();

        if ($this instanceof WithoutNullValues) {
            return array_filter(
                $array,
                static fn ($value) => ! is_null($value)
            );
        }

        return $array;
    }
}
