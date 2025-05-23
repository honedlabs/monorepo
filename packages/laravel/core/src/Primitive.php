<?php

declare(strict_types=1);

namespace Honed\Core;

use Honed\Core\Concerns\Evaluable;
use Illuminate\Support\Traits\Tappable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Conditionable;

abstract class Primitive implements \JsonSerializable
{
    use Evaluable;
    use Conditionable;
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
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    public function setUp()
    {
        //
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
