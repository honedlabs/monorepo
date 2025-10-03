<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Contracts\Formatter;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @implements Formatter<array<int, mixed>|Collection<int, mixed>, array<int, mixed>|string>
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
     * @param  string  $pluck
     * @return $this
     */
    public function pluck($pluck)
    {
        $this->pluck = $pluck;

        return $this;
    }

    /**
     * Get the property to pluck from the array.
     *
     * @return string|null
     */
    public function getPluck()
    {
        return $this->pluck;
    }

    /**
     * Set the separator to use when joining the array.
     *
     * @param  string  $glue
     * @return $this
     */
    public function glue($glue = ', ')
    {
        $this->glue = $glue;

        return $this;
    }

    /**
     * Get the separator to use when joining the array.
     *
     * @return string|null
     */
    public function getGlue()
    {
        return $this->glue;
    }

    /**
     * Format the value by plucking a property from the array.
     *
     * @param  array<string, mixed>  $value
     * @return array<int, mixed>
     */
    protected function formatPluck($value)
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
    protected function formatGlue($value)
    {
        $glue = $this->getGlue();

        return $glue ? implode($glue, $value) : $value;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function format(mixed $value): mixed
    {
        if (is_null($value)) {
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
}