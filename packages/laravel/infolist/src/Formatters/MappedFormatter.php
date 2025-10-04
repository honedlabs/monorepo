<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use BackedEnum;
use Closure;
use Honed\Infolist\Contracts\Formatter;

/**
 * @implements Formatter<int|string|\BackedEnum, mixed>
 */
class MappedFormatter implements Formatter
{
    /**
     * The mapping to use.
     *
     * @var array<array-key, mixed>|Closure(int|string|BackedEnum|null):mixed
     */
    protected $mapping = [];

    /**
     * The default value to use if the value is not found in the mapping.
     *
     * @var mixed
     */
    protected $default;

    /**
     * Set the mapping to use.
     *
     * @param  array<array-key, mixed>|Closure(int|string|BackedEnum|null):mixed  $value
     * @return $this
     */
    public function mapping(array|Closure $value): static
    {
        $this->mapping = $value;

        return $this;
    }

    /**
     * Get the mapping to use.
     *
     * @return array<array-key, mixed>|Closure(int|string|BackedEnum|null):mixed
     */
    public function getMapping(): array|Closure
    {
        return $this->mapping;
    }

    /**
     * Set the default value to use if the value is not found in the mapping.
     *
     * @return $this
     */
    public function default(mixed $value): static
    {
        $this->default = $value;

        return $this;
    }

    /**
     * Get the default value to use if the value is not found in the mapping.
     */
    public function getDefault(): mixed
    {
        return $this->default;
    }

    /**
     * Format the value using a mapping.
     *
     * @param  int|string|BackedEnum|null  $value
     */
    public function format(mixed $value): mixed
    {
        if (is_callable($this->mapping)) {
            return ($this->mapping)($value) ?? $this->default;
        }

        if (is_scalar($value) && isset($this->mapping[$value])) {
            return $this->mapping[$value];
        }

        return $this->default;
    }
}
