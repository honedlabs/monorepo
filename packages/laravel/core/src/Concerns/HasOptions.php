<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Option;
use Illuminate\Database\Eloquent\Model;

trait HasOptions
{
    /**
     * @var \Illuminate\Support\Collection<int,\Honed\Core\Option>
     */
    protected $options;

    /**
     * Get or set the options for the instance.
     *
     * @param  \Honed\Core\Option|class-string<\BackedEnum>|class-string<\Illuminate\Database\Eloquent\Model>|null  $option The option to add, or null to retrieve the current options.
     * @param  \Illuminate\Support\Collection<int,\Honed\Core\Option>|string  $options The options to add, or accessors for the given first argument.
     * @return \Illuminate\Support\Collection<int,\Honed\Core\Option>|null The current options when no argument is provided, or the instance when setting the options.
     */
    public function options($option = null, ...$options)
    {
        if (\is_null($option)) {
            return $this->options;
        }

        $options = $option instanceof Option 
            ? collect([$option, ...$options])
            : collect(match (true) {
                \is_string($option) && \enum_exists($option) => $option::cases(),
                \is_string($option) => $option::all(),
                default => $option,
            })->map(fn ($case) => Option::make(
                $this->parseOptionValue($case, isset($options[0]) ? $options[0] : null) ?? $case->value,
                $this->parseOptionValue($case, isset($options[1]) ? $options[1] : null) ?? $case->name
            ));

        $this->options = $options;

        return $this;
    }

    /**
     * Determine if the instance has options.
     * 
     * @return bool True if the instance has options, false otherwise.
     */
    public function hasOptions()
    {
        return isset($this->options) && $this->options()->isNotEmpty();
    }

    /**
     * Get an option field from an item.
     *
     * @param  mixed  $item The item to get the field from.
     * @param  string|null  $key The key to get the field from, or null to use the item itself.
     * @return mixed The field value.
     */
    private function parseOptionValue($item, $key = null)
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
