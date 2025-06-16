<?php

declare(strict_types=1);

namespace Honed\List\Entries\Concerns;

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
    protected ?string $pluck = null;

    /**
     * The separator to use when joining the array.
     * 
     * @var string|null
     */
    protected ?string $glue = null;

    /**
     * Set the property to pluck from the array.
     * 
     * @param  string  $pluck
     * @return $this
     */
    public function pluck(string $pluck): static
    {
        $this->pluck = $pluck;

        return $this;
    }

    /**
     * Get the property to pluck from the array.
     * 
     * @return string|null
     */
    public function getPluck(): ?string
    {
        return $this->pluck;
    }

    /**
     * Determine if a pluck property is set.
     * 
     * @return bool
     */
    public function hasPluck(): bool
    {
        return isset($this->pluck);
    }

    /**
     * Set the separator to use when joining the array.
     * 
     * @param  string  $glue
     * @return $this
     */
    public function glue(string $glue): static
    {
        $this->glue = $glue;

        return $this;
    }

    /**
     * Get the separator to use when joining the array.
     * 
     * @return string|null
     */
    public function getGlue(): ?string
    {
        return $this->glue;
    }

    /**
     * Determine if a glue separator is set.
     * 
     * @return bool
     */
    public function hasGlue(): bool
    {
        return isset($this->glue);
    }

    /**
     * Format the value as an array.
     * 
     * @param  mixed  $value
     * @return array|string|null
     */
    protected function formatArray(mixed $value): array|string|null
    {
        if (! is_iterable($value)) {
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
     * @param  array  $value
     * @return array
     */
    protected function formatPluck(array $value): array
    {
        return $this->hasPluck() 
            ? Arr::pluck($value, $this->getPluck())
            : $value;
    }

    /**
     * Format the value by joining the array with a separator.
     * 
     * @param  array  $value
     * @return array|string
     */
    protected function formatGlue(array $value): array|string
    {
        return $this->hasGlue() 
            ? implode($this->getGlue(), $value)
            : $value;
    }
}