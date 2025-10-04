<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Contracts\Formatter;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @implements Formatter<array<int, mixed>|\Illuminate\Support\Collection<int, mixed>, array<int, mixed>|string>
 */
class ArrayFormatter implements Formatter
{
    /**
     * The property to pluck from the array.
     *
     * @var string|null
     */
    protected $pluck;

    /**
     * The separator to use when joining the array.
     *
     * @var string|null
     */
    protected $glue;

    /**
     * Set the property to pluck from the array.
     *
     * @return $this
     */
    public function pluck(string $value): static
    {
        $this->pluck = $value;

        return $this;
    }

    /**
     * Get the property to pluck from the array.
     */
    public function getPluck(): ?string
    {
        return $this->pluck;
    }

    /**
     * Set the separator to use when joining the array.
     *
     * @return $this
     */
    public function glue(string $value = ', '): static
    {
        $this->glue = $value;

        return $this;
    }

    /**
     * Get the separator to use when joining the array.
     */
    public function getGlue(): ?string
    {
        return $this->glue;
    }

    /**
     * Format the value as an array.
     *
     * @param  array<int, mixed>|Collection<int, mixed>|null  $value
     * @return array<int, mixed>|string|null
     */
    public function format(mixed $value): mixed
    {
        if (! Arr::accessible($value)) {
            return null;
        }

        $pipes = [
            'formatPluck',
            'formatGlue',
        ];

        return array_reduce(
            $pipes,
            fn ($value, $pipe) => $this->{$pipe}($value),
            $value instanceof Collection ? $value->all() : $value
        );
    }

    /**
     * Format the value by plucking a property from the array.
     *
     * @param  array<string, mixed>  $value
     * @return array<int, mixed>
     */
    protected function formatPluck(array $value): array
    {
        $pluck = $this->getPluck();

        return $pluck ? Arr::pluck($value, $pluck) : $value;
    }

    /**
     * Format the value by joining the array with a separator.
     *
     * @param  array<int, mixed>  $value
     * @return array<int, mixed>|string
     */
    protected function formatGlue(array $value): array|string
    {
        $glue = $this->getGlue();

        return $glue ? implode($glue, $value) : $value;
    }
}
