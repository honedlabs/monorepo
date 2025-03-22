<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Refine\Contracts\DefinesOptions;
use Honed\Refine\Option;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait HasOptions
{
    /**
     * The available options.
     *
     * @var array<int,\Honed\Refine\Option>|null
     */
    protected $options;

    /**
     * Whether to restrict options to only those provided.
     *
     * @var bool|null
     */
    protected $strict;

    /**
     * Whether to accept multiple values.
     *
     * @var bool
     */
    protected $multiple = false;

    /**
     * Set the options for the filter.
     *
     * @param  class-string<\BackedEnum>|array<int,mixed>|Collection<int,mixed>  $options
     * @return $this
     */
    public function options($options)
    {
        if ($options instanceof Collection) {
            $options = $options->all();
        }

        $this->options = $this->createOptions($options);

        return $this;
    }

    /**
     * Create options from a value.
     *
     * @param  class-string<\BackedEnum>|array<int,mixed>|Collection<int,mixed>  $options
     * @return array<int,\Honed\Refine\Option>
     */
    public function createOptions($options)
    {
        if (\is_string($options)) {
            return \array_map(
                static fn ($case) => Option::make($case->value, $case->name),
                $options::cases()
            );
        }

        if (Arr::isAssoc($options)) {
            return \array_map(
                static fn ($value, $key) => Option::make($value, \strval($key)),
                \array_keys($options),
                \array_values($options)
            );
        }

        return \array_map(
            static fn ($value) => $value instanceof Option 
                ? $value 
                : Option::make($value, \strval($value)),
            $options
        );
    }

    /**
     * Get the options.
     *
     * @return array<int,\Honed\Refine\Option>
     */
    public function getOptions()
    {
        if (isset($this->options)) {
            return $this->options;
        }

        if ($this instanceof DefinesOptions) {
            return $this->options 
                ??= $this->createOptions($this->defineOptions());
        }

        return [];
    }

    /**
     * Determine if the filter has options.
     *
     * @return bool
     */
    public function hasOptions()
    {
        return filled($this->getOptions());
    }

    /**
     * Get the options as an array.
     *
     * @return array<int,mixed>
     */
    public function optionsToArray()
    {
        return \array_map(
            static fn (Option $option) => $option->toArray(),
            $this->getOptions()
        );
    }

    /**
     * Restrict the options to only those provided.
     *
     * @param  bool  $strict
     * @return $this
     */
    public function strict($strict = true)
    {
        $this->strict = $strict;

        return $this;
    }

    /**
     * Allow any options to be used.
     *
     * @param  bool  $lax
     * @return $this
     */
    public function lax($lax = true)
    {
        return $this->strict(! $lax);
    }

    /**
     * Determine if only the options provided are allowed.
     *
     * @return bool
     */
    public function isStrict()
    {
        return $this->strict ?? static::isStrictByDefault();
    }

    /**
     * Determine if only the options provided are allowed.
     *
     * @return bool
     */
    public static function isStrictByDefault()
    {
        return (bool) config('refine.strict', false);
    }

    /**
     * Allow multiple options to be used.
     *
     * @return $this
     */
    public function multiple()
    {
        $this->multiple = true;

        return $this;
    }

    /**
     * Determine if multiple options are allowed.
     *
     * @return bool
     */
    public function isMultiple()
    {
        return $this->multiple;
    }
    /**
     * Activate the options and return the valid options.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function activateOptions($value)
    {
        $options = (new Collection($this->getOptions()))
            ->filter(static fn (Option $option) => $option->activate($value))
            ->values();

        return match (true) {
            $this->isStrict() &&
                $this->isMultiple() => $options->map->getValue()->all(),

            $this->isMultiple() => Arr::wrap($value),

            $this->isStrict() => $options->first()?->getValue(),

            default => $value
        };
    }
}
