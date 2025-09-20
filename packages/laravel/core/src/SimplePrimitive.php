<?php

declare(strict_types=1);

namespace Honed\Core;

use Honed\Core\Contracts\NullsAsUndefined;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\JsonEncodingException;
use JsonException;
use JsonSerializable;

use function array_filter;

/**
 * @template TKey of array-key = string
 * @template TValue of mixed = mixed
 *
 * @implements Arrayable<TKey,TValue>
 */
abstract class SimplePrimitive implements Arrayable, Jsonable, JsonSerializable
{
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
