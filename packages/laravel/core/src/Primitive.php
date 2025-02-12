<?php

declare(strict_types=1);

namespace Honed\Core;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

/**
 * @template TKey of string
 * @template TValue of mixed
 *
 * @implements Arrayable<TKey,TValue>
 */
abstract class Primitive implements \JsonSerializable, Arrayable, Contracts\Makeable
{
    use Concerns\Evaluable;
    use Conditionable;
    use Macroable;
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
        return \array_filter($this->toArray(), static fn ($value) => ! empty($value));
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
}
