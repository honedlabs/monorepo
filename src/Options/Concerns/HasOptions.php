<?php

namespace Conquest\Core\Options\Concerns;

use BackedEnum;
use Conquest\Core\Options\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Specify whether this class contains options
 *
 * @property array<Option> $options
 */
trait HasOptions
{
    protected array $options = [];

    /**
     * Set the options, chainable
     *
     * @param  array<Option>  $options
     */
    public function options(array $options): static
    {
        $this->setOptions($options);

        return $this;
    }

    /**
     * Set the options from an enum, chainable. It will default to using the backing value and enum name.
     *
     * @param  BackedEnum-string  $enum
     */
    public function optionsFromEnum(string $enum, ?string $value = null, ?string $label = null): static
    {
        foreach ($enum::cases() as $case) {
            $optionValue = ($value && method_exists($case, $value)) ? $case->{$value}() : $case->value;
            $optionLabel = ($label && method_exists($case, $label)) ? $case->{$label}() : $case->name;
            $this->addOption($this->parseOption($optionValue, $optionLabel));
        }

        return $this;
    }

    /**
     * Set the options from a model, chainable. It will default to using the Model key.
     *
     * @param  class-string  $model
     */
    public function optionsFromModel(string $model, ?string $value = null, ?string $label = null): static
    {
        foreach ($model::all() as $modelInstance) {
            $optionValue = $this->getOptionField($modelInstance, $value) ?? $modelInstance->getKey();
            $optionLabel = $label !== null ? $this->getOptionField($modelInstance, $label) : null;
            $this->addOption($this->parseOption($optionValue, $optionLabel));
        }

        return $this;
    }

    /**
     * Set the options from a collection, chainable. It will default to using the collection item.
     */
    public function optionsFromCollection(Collection $collection, ?string $value = null, ?string $label = null): static
    {
        $collection->each(function ($item) use ($value, $label) {
            $optionValue = $this->getOptionField($item, $value) ?? $item;
            $optionLabel = $label !== null ? $this->getOptionField($item, $label) : null;
            $this->addOption($this->parseOption($optionValue, $optionLabel));
        });

        return $this;
    }

    private function getOptionField($item, ?string $key): mixed
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
     * @param  string  $value
     */
    public function parseOption(mixed $value, ?string $label = null): Option
    {
        return Option::make($value, $label);
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
     * Check if the class has options
     */
    public function hasOptions(): bool
    {
        return ! empty($this->options);
    }

    /**
     * Check if the class doesn't have options
     */
    public function lacksOptions(): bool
    {
        return ! $this->hasOptions();
    }
}
