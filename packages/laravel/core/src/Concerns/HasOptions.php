<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait HasOptions
{
    /**
     * @var \Illuminate\Support\Collection<int,\Honed\Core\Option>
     */
    protected $options;

    /**
     * Get or set the options for the instance.
     *
     * @param  \Honed\Core\Option|class-string<\BackedEnum>|class-string<\Illuminate\Database\Eloquent\Model>|null  $option
     * @param  array<int,\Honed\Core\Option|string>  $options
     * @return $this
     */
    public function options($option, ...$options): static
    {
        if (! \is_null($option)) {
            $this->options = $option instanceof Option
                ? collect([$option, ...$options])
                : collect(match (true) {
                    \is_string($option) && \enum_exists($option) => $option::cases(),
                    \is_string($option) => $option::all(),
                    default => $option,
                })->map(fn ($case) => Option::make(
                    $this->parseOptionValue($case, isset($options[0]) ? $options[0] : null) ?? $case->value,
                    $this->parseOptionValue($case, isset($options[1]) ? $options[1] : null) ?? $case->name
                ));
        }

        return $this;
    }

    /**
     * Get the options for the instance.
     *
     * @return \Illuminate\Support\Collection<int,\Honed\Core\Option>|null
     */
    public function getOptions(): ?Collection
    {
        return $this->options;
    }

    /**
     * Determine if the instance has options.
     */
    public function hasOptions(): bool
    {
        return isset($this->options) && $this->getOptions()->isNotEmpty();
    }

    /**
     * Get an option field from an item.
     */
    private function parseOptionValue(mixed $item, ?string $key = null): mixed
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
}
