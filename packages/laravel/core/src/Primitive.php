<?php

declare(strict_types=1);

namespace Honed\Core;

use BadMethodCallException;
use Honed\Core\Concerns\Configurable;
use Honed\Core\Concerns\Definable;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Contracts\NullsAsUndefined;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use JsonException;
use JsonSerializable;

use function array_filter;

/**
 * @template TKey of array-key = string
 * @template TValue of mixed = mixed
 *
 * @implements Arrayable<TKey,TValue>
 */
abstract class Primitive implements Arrayable, Jsonable, JsonSerializable
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

    /**
     * Get the representation of the instance.
     *
     * @return array<TKey,TValue>
     */
    abstract protected function representation(): array;

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
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        if ($this instanceof NullsAsUndefined) {
            return $this->undefine($this->representation());
        }

        return $this->representation();
    }

    /**
     * Convert the primitive instance to JSON.
     *
     * @param  int  $options
     *
     * @throws JsonEncodingException
     */
    public function toJson($options = 0): string
    {
        try {
            $json = json_encode($this->jsonSerialize(), $options | JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new JsonEncodingException(
                'Error encoding primitive ['.get_class($this).'] to JSON: '.$e->getMessage()
            );
        }

        return $json;
    }

    /**
     * Set null values to undefined by filtering the key (non recursive).
     *
     * @param  array<TKey,TValue>  $value
     * @return array<TKey,TValue>
     */
    protected function undefine(array $value): array
    {
        return array_filter(
            $value,
            static fn ($value) => ! is_null($value)
        );
    }
}
