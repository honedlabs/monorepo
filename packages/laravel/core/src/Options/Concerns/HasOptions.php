<?php

declare(strict_types=1);

namespace Honed\Core\Options\Concerns;

use Honed\Core\Options\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Specify whether this class contains options
 *
 * @property array<Option> $options
 */
trait HasOptions
{
    /**
     * @var array<int, Option>
     */
    protected $options = [];

    /**
     * Set the options, chainable
     *
     * @param  array<int,mixed>|\Illuminate\Support\Collection|class-string<\BackedEnum>|class-string<\Illuminate\Database\Eloquent\Model>  $options
     * @return $this
     */
    public function options(array|Collection|string $options): static
    {
        match (true) {
            $options instanceof Collection => $this->fromCollection($options),
            \is_string($options) && \enum_exists($options) => $this->fromEnum($options),
            \is_string($options) => $this->fromModel($options), // if string, assume model
            default => $this->setOptions($options), // array
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
        foreach ($enum::cases() as $case) {
            $optionValue = ($value && method_exists($case, $value)) ? $case->{$value}() : $case->value;
            $optionLabel = ($label && method_exists($case, $label)) ? $case->{$label}() : $case->name;
            $this->addOption($this->parseOption($optionValue, $optionLabel));
        }

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
        foreach ($model::all() as $modelInstance) {
            $optionValue = $this->getOptionField($modelInstance, $value) ?? $modelInstance->getKey();
            $optionLabel = $label !== null ? $this->getOptionField($modelInstance, $label) : null;
            $this->addOption($this->parseOption($optionValue, $optionLabel));
        }

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
            $optionValue = $this->getOptionField($item, $value) ?? $item;
            $optionLabel = $label !== null ? $this->getOptionField($item, $label) : null;
            $this->addOption($this->parseOption($optionValue, $optionLabel));
        });

        return $this;
    }

    /**
     * Set the options quietly.
     *
     * @param  array<Option>|null  $options
     */
    public function setOptions(?array $options): void
    {
        if (is_null($options)) {
            return;
        }

        foreach ($options as $value => $label) {
            if ($label instanceof Option) {
                $option = $label;
            } elseif (is_int($value)) {
                $option = $this->parseOption($label);
            } else {
                $option = $this->parseOption($value, $label);
            }
            $this->addOption($option);
        }
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
     * @return array<Option>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Determine if the class is missing options.
     */
    public function missingOptions(): bool
    {
        return empty($this->options);
    }

    /**
     * Determine if the class has options.
     */
    public function hasOptions(): bool
    {
        return ! $this->missingOptions();
    }

    /**
     * Get an option field from an item.
     *
     * @param  array|object  $item
     */
    protected function getOptionField(mixed $item, ?string $key): mixed
    {
        if ($key === null) {
            return null;
        }

        if (is_array($item)) {
            return $item[$key] ?? null;
        }

        if (is_object($item)) {
            if (method_exists($item, $key)) {
                return $item->{$key}();
            }

            if (property_exists($item, $key)) {
                return $item->{$key};
            }

            if (method_exists($item, 'getAttribute')) {
                return $item->getAttribute($key);
            }
        }

        return null;
    }

    /**
     * Parse a value and label as an Option class.
     *
     * @param  int|string|array|(\Closure():int|string|array)|null  $value
     */
    protected function parseOption(mixed $value, ?string $label = null): Option
    {
        return Option::make($value, $label);
    }
}
