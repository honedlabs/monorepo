<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait HasOptions
{
    /**
     * @var array<int,\Honed\Core\Option>
     */
    protected $options;

    /**
     * Set the options, chainable
     *
     * @param  array<int,mixed>|\Illuminate\Support\Collection|class-string<\BackedEnum>|class-string<\Illuminate\Database\Eloquent\Model>|\Honed\Core\Options\Option  $option
     * @param  array<int,\Honed\Core\Options\Option>  $options
     * @return $this
     */
    public function options(array|string|Collection|Option $option, ...$options): static
    {
        match (true) {
            $option instanceof Collection => $this->fromCollection($option),
            $option instanceof Option => $this->setOptions([$option, ...$options]),
            \is_string($option) && \enum_exists($option) => $this->fromEnum($option),
            \is_string($option) => $this->fromModel($option),
            default => $this->setOptions($option),
        };

        return $this;
    }

    /**
     * Set the options from an enum, chainable.
     * Defaults to using the backing value and enum name.
     *
     * @param  class-string<\BackedEnum>  $enum
     * @return $this
     */
    public function fromEnum(string $enum, ?string $value = null, ?string $label = null): static
    {
        collect($enum::cases())->each(function ($case) use ($value, $label) {
            $this->addOption($this->parseOption(
                $this->getOptionField($case, $value) ?? $case->value,
                $this->getOptionField($case, $label) ?? $case->name
            ));
        });

        return $this;
    }

    /**
     * Set the options from a model, chainable.
     * Defaults to using the Model key.
     *
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $model
     * @return $this
     */
    public function fromModel(string $model, ?string $value = null, ?string $label = null): static
    {
        collect($model::all())->each(function ($instance) use ($value, $label) {
            $this->addOption($this->parseOption(
                $this->getOptionField($instance, $value) ?? $instance->getKey(),
                $this->getOptionField($instance, $label)
            ));
        });

        return $this;
    }

    /**
     * Set the options from a collection, chainable.
     * Defaults to using the collection item for the value.
     *
     * @return $this
     */
    public function fromCollection(Collection $collection, ?string $value = null, ?string $label = null): static
    {
        $collection->each(function ($item) use ($value, $label) {
            $this->addOption($item instanceof Option
                ? $item
                : $this->parseOption(
                    $this->getOptionField($item, $value) ?? $item,
                    $this->getOptionField($item, $label)
                )
            );
        });

        return $this;
    }

    /**
     * Set the options quietly.
     *
     * @param  array<\Honed\Core\Options\Option>|null  $options
     */
    public function setOptions(?array $options): void
    {
        if (\is_null($options)) {
            return;
        }

        collect($options)->each(function ($value, $key) {
            $this->addOption(match (true) {
                $value instanceof Option => $value,
                \is_int($key) => $this->parseOption($value),
                default => $this->parseOption($key, $value),
            });
        });
    }

    /**
     * Add a single option to the class.
     */
    public function addOption(Option $option): void
    {
        $this->options[] = $option;
    }

    /**
     * Get the options
     *
     * @return array<int,\Honed\Core\Options\Option>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Get the options as a collection.
     *
     * @return \Illuminate\Support\Collection<int,\Honed\Core\Options\Option>
     */
    public function collectOptions(): Collection
    {
        return collect($this->options);
    }

    /**
     * Determine if the class has options.
     */
    public function hasOptions(): bool
    {
        return \count($this->options) > 0;
    }

    /**
     * Get an option field from an item.
     *
     * @internal
     */
    protected function getOptionField(mixed $item, ?string $key = null): mixed
    {

        return match (true) {
            \is_null($key) => null,
            $item instanceof Model => $item->getAttribute($key),
            \is_array($item) => $item[$key] ?? null,
            ! \is_object($item) => null,
            \method_exists($item, $key) => $item->{$key}(),
            \property_exists($item, $key) => $item->{$key},
            default => null,
        };
    }

    /**
     * Parse a value and label as an Option class.
     *
     * @internal
     */
    protected function parseOption(mixed $value, ?string $label = null): Option
    {
        return Option::make($value, $label);
    }
}
