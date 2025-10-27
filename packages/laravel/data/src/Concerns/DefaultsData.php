<?php

declare(strict_types=1);

namespace Honed\Data\Concerns;

/**
 * @phpstan-require-extends \Spatie\LaravelData\Data
 *
 * @phpstan-require-implements \Honed\Data\Contracts\Defaultable
 */
trait DefaultsData
{
    /**
     * Get the defaults for the data.
     *
     * @return array<string, mixed>
     */
    abstract public static function getDefaults(): array;

    /**
     * Create an empty instance of the data.
     *
     * @param  array<string, mixed>  $extra
     * @param  array<int,string>|null  $except
     * @param  array<int,string>|null  $only
     * @return array<string, mixed>
     */
    public static function empty(array $extra = [], mixed $replaceNullValuesWith = null, ?array $except = null, ?array $only = null): array
    {
        return parent::empty([...static::getDefaults(), ...$extra], $replaceNullValuesWith, $except, $only);
    }
}
