<?php

declare(strict_types=1);

namespace Honed\Core;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

/**
 * @implements Arrayable<string,mixed>
 */
abstract class Primitive implements \JsonSerializable, Arrayable
{
    use Concerns\Evaluable;
    use Conditionable;
    use Macroable {
        __call as macroCall;
    }
    use Tappable;

    /**
     * The properties to include in the serialization.
     *
     * @var array<int, string>
     */
    protected $only = [];

    /**
     * The properties to exclude from the serialization.
     *
     * @var array<int, string>
     */
    protected $except = [];

    /**
     * Construct the instance.
     */
    public function __construct()
    {
        $this->setUp();
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
     * Set the properties to include in the serialization.
     *
     * @param  string|array<int, string>  ...$only
     * @return $this
     */
    public function only(...$only)
    {
        $only = Arr::flatten($only);

        $this->only = \array_merge($this->only, $only);

        return $this;
    }

    /**
     * Set the properties to exclude from the serialization.
     *
     * @param  string|array<int, string>  ...$except
     * @return $this
     */
    public function except(...$except)
    {
        $except = Arr::flatten($except);

        $this->except = \array_merge($this->except, $except);

        return $this;
    }

    /**
     * Determine if the property exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        if (filled($this->only)) {
            return \in_array($key, $this->only);
        }

        return ! \in_array($key, $this->except);
    }

    /**
     * Serialize the instance
     *
     * @return array<string,mixed>
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
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
        return $this->macroCall($method, $parameters);
    }
}
