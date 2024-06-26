<?php

namespace Conquest\Core;

use ArrayAccess;
use Conquest\Core\Contracts\Makeable;

/**
 * Access objects or arrays interchangeably.
 */
class Accessor implements ArrayAccess, Makeable
{
    private mixed $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function make(array $data): static
    {
        return new static($data);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    public function __get($name)
    {
        return $this->data[$name];
    }
}