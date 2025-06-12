<?php

declare(strict_types=1);

namespace Honed\Refine\Filters\Concerns;

use BackedEnum;
use Honed\Refine\Option;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

use function array_filter;
use function array_keys;
use function array_map;
use function array_values;
use function is_string;

trait HasOptions
{
    /**
     * The available options.
     *
     * @var array<int,Option>
     */
    protected $options = [];

    /**
     * Whether to restrict options to only those provided.
     *
     * @var bool
     */
    protected $strict = false;

    /**
     * Whether to accept multiple values.
     *
     * @var bool
     */
    protected $multiple = false;

    /**
     * Set the options for the filter.
     *
     * @template TValue of bool|float|int|string|null|\Honed\Refine\Option
     *
     * @param  class-string<BackedEnum>|array<int|string,TValue>|Collection<int|string,TValue>  $options
     * @return $this
     */
    public function options($options)
    {
        $this->options = $this->createOptions($options);

        return $this;
    }

    /**
     * Get the options.
     *
     * @return array<int,Option>
     */
    public function getOptions()
    {
        return $this->options;
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
        return $this->strict;
    }

    /**
     * Allow multiple options to be used.
     *
     * @param  bool  $multiple
     * @return $this
     */
    public function multiple($multiple = true)
    {
        $this->multiple = $multiple;

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
     * Determine if only one option is allowed.
     *
     * @return bool
     */
    public function isNotMultiple()
    {
        return ! $this->isMultiple();
    }

    /**
     * Activate the options and return the valid options.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function activateOptions($value)
    {
        $options = array_values(
            array_filter(
                $this->getOptions(),
                // Set and activate the option
                static fn (Option $option) => $option->activate($value)
            )
        );

        return match (true) {
            $this->isStrict() &&
                $this->isMultiple() => array_map(
                    static fn (Option $option) => $option->getValue(),
                    $options
                ),

            $this->isMultiple() => Arr::wrap($value),

            $this->isStrict() => Arr::first($options)?->getValue(),

            default => $value
        };
    }

    /**
     * Get the options as an array.
     *
     * @return array<int,mixed>
     */
    public function optionsToArray()
    {
        return array_map(
            static fn (Option $option) => $option->toArray(),
            $this->getOptions()
        );
    }

    /**
     * Create options from a value.
     *
     * @template TValue of scalar|null|\Honed\Refine\Option
     *
     * @param  class-string<BackedEnum>|array<int|string,TValue>|Collection<int|string,TValue>  $options
     * @return array<int,Option>
     */
    protected function createOptions($options)
    {
        if ($options instanceof Collection) {
            $options = $options->all();
        }

        if (is_string($options)) {
            return array_map(
                static fn ($case) => Option::make($case->value, $case->name),
                $options::cases()
            );
        }

        if (Arr::isAssoc($options)) {
            return array_map(
                // @phpstan-ignore-next-line
                static fn ($value, $key) => Option::make($value, (string) $key),
                array_keys($options),
                array_values($options)
            );
        }

        return array_values(
            array_map(
                static fn ($value) => $value instanceof Option
                    ? $value
                    : Option::make($value, (string) $value),
                $options
            )
        );
    }
}
