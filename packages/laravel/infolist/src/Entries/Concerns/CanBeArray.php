<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait CanBeArray
{
    public const ARRAY = 'array';

    /**
     * The property to pluck from the array.
     *
     * @var string|null
     */
    protected $pluck = null;

    /**
     * The separator to use when joining the array.
     *
     * @var string|null
     */
    protected $glue = null;

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
     * Format the value as an array.
     *
     * @param  array<int, mixed>|Collection<int, mixed>  $value
     * @return array<int, mixed>|string|null
     */
    protected function formatArray($value)
    {
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
}
