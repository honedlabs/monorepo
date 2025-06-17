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
     * @var array<int, Option>
     */
    protected array $options = [];

    /**
     * Whether to restrict options to only those provided.
     *
     * @var bool
     */
    protected bool $strict = false;

    /**
     * Whether to accept multiple values.
     *
     * @var bool
     */
    protected bool $multiple = false;

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
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Determine if the filter has options.
     *
     * @return bool
     */
    public function hasOptions(): bool
    {
        return filled($this->getOptions());
    }

    /**
     * Restrict the options to only those provided.
     *
     * @param  bool  $strict
     * @return $this
     */
    public function strict(bool $strict = true): self
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
    public function lax(bool $lax = true): self
    {
        return $this->strict(! $lax);
    }

    /**
     * Determine if only the options provided are allowed.
     *
     * @return bool
     */
    public function isStrict(): bool
    {
        return $this->strict;
    }

    /**
     * Allow multiple options to be used.
     *
     * @param  bool  $multiple
     * @return $this
     */
    public function multiple(bool $multiple = true): self
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * Determine if multiple options are allowed.
     *
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * Determine if only one option is allowed.
     *
     * @return bool
     */
    public function isNotMultiple(): bool
    {
        return ! $this->isMultiple();
    }

    /**
     * Activate the options and return the valid options.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function activateOptions(mixed $value): mixed
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
    public function optionsToArray(): array
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
    protected function createOptions(array|string|Collection $options): array
    {
        if ($options instanceof Collection) {
            $options = $options->all();
        }

        return match (true) {
            is_string($options) => $this->createEnumOptions($options),
            Arr::isAssoc($options) => $this->createAssociativeOptions($options),
            default => $this->createListOptions($options),
        };
    }

    /**
     * Create options from a backed enum.
     *
     * @param  class-string<BackedEnum>  $enum
     * @return array<int,Option>
     */
    protected function createEnumOptions(string $enum): array
    {
        return array_map(
            static fn ($case) => Option::make($case->value, $case->name),
            $enum::cases()
        );
    }

    /**
     * Create options from an associative array.
     *
     * @param  array<int|string,mixed>  $options
     * @return array<int,Option>
     */
    protected function createAssociativeOptions(array $options): array
    {
        return array_map(
            static fn ($value, $key) => Option::make($value, (string) $key),
            array_keys($options),
            array_values($options)
        );
    }

    /**
     * Create options from a list of values.
     *
     * @param  array<int|string,mixed>  $options
     * @return array<int,Option>
     */
    protected function createListOptions(array $options): array
    {
        return array_map(
            static fn ($value) => $value instanceof Option
                ? $value
                : Option::make($value, (string) $value),
            $options
        );
    }
}
