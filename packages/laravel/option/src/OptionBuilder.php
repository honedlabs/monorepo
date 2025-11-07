<?php

declare(strict_types=1);

namespace Honed\Option;

use BackedEnum;
use Honed\Core\Contracts\HasLabel;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class OptionBuilder
{
    /**
     * Create many options from the given input.
     *
     * @template T of bool|float|int|string|\Honed\Option\Option|\BackedEnum
     *
     * @param  class-string<BackedEnum>|array<int|string,T>|Collection<int|string,T>|Arrayable<int|string,T>  $value
     * @return array<int,Option>
     */
    public static function many(string|array|Collection|Arrayable $value): array
    {
        if (is_string($value)) {
            return static::enum($value);
        }

        /** @var array<int|string, T> $value */
        $value = match (true) {
            $value instanceof Collection => $value->all(),
            $value instanceof Arrayable => $value->toArray(),
            default => $value,
        };

        return array_is_list($value)
            ? static::list($value)
            : static::object($value);  // @phpstan-ignore-line argument.type
    }

    /**
     * Generate options from an associative array.
     *
     * @param  array<int|string,string|BackedEnum>  $value
     * @return array<int,Option>
     */
    public static function object(array $value): array
    {
        return array_map(
            static fn (int|string $key, string|BackedEnum $value) => static::from($key, $value),
            array_keys($value),
            array_values($value)
        );
    }

    /**
     * Generate options from a list.
     *
     * @param  list<scalar|Option|BackedEnum|null>  $value
     * @return array<int,Option>
     */
    public static function list(array $value): array
    {
        return array_map(
            static fn (mixed $value) => static::from($value),
            $value
        );
    }

    /**
     * Generate options from an enum.
     *
     * @param  class-string<BackedEnum>  $value
     * @return array<int,Option>
     */
    public static function enum(string $value): array
    {
        return static::list($value::cases());
    }

    /**
     * Generate an option from the given value and label pair.
     *
     * @param  scalar|Option|BackedEnum|null  $value
     */
    public static function from(mixed $value, string|BackedEnum|null $label = null): Option
    {
        if ($value instanceof Option) {
            return $value;
        }

        $label = match (true) {
            $label instanceof HasLabel => $label->getLabel(),
            $label instanceof BackedEnum => $label->name,
            $value instanceof HasLabel => $value->getLabel(),
            $value instanceof BackedEnum => $value->name,
            default => (string) $value,
        };

        return Option::make(
            is_scalar($value) || is_null($value) ? $value : $value->value,
            $label
        );
    }
}
