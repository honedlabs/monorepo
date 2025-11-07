<?php

declare(strict_types=1);

namespace Honed\Option\Concerns;

use BackedEnum;
use Closure;
use Honed\Option\Option;
use Honed\Option\OptionBuilder;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

trait HasOptions
{
    /**
     * The available options.
     *
     * @var array<int, Option>
     */
    protected $options = [];

    /**
     * Set the options for the filter.
     *
     * @template TValue of bool|float|int|string|null|\Honed\Option\Option
     *
     * @param  class-string<BackedEnum>|array<int|string,TValue>|Collection<int|string,TValue>|Arrayable<int|string,TValue>  $options
     * @return $this
     */
    public function options(string|array|Collection|Arrayable $options)
    {
        $this->options = OptionBuilder::many($options);

        return $this;
    }

    /**
     * Add a new option
     *
     * @return $this
     */
    public function option(mixed $value, string|Closure|null $label = null): static
    {
        $this->options[] = OptionBuilder::from($value, $label);

        return $this;
    }

    /**
     * Prepend an option to the beginning of the list.
     *
     * @param  scalar|Option|BackedEnum|null  $value
     * @return $this
     */
    public function beforeAll(mixed $value): static
    {
        array_unshift($this->options, OptionBuilder::from($value));

        return $this;
    }

    /**
     * Append an option to the end of the list.
     *
     * @param  scalar|Option|BackedEnum|null  $value
     * @return $this
     */
    public function afterAll(mixed $value): static
    {
        return $this->option($value);

    }

    /**
     * Get the options.
     *
     * @return array<int,Option>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Determine if the instance has options.
     */
    public function hasOptions(): bool
    {
        return filled($this->options);
    }

    /**
     * Determine if there are no available options.
     */
    public function missingOptions(): bool
    {
        return empty($this->options);
    }

    /**
     * Get the options as an array.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getOptionsArray()
    {
        return array_map(
            static fn (Option $option) => $option->toArray(),
            $this->getOptions()
        );
    }
}
