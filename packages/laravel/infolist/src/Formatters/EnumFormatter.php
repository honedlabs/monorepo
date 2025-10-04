<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Contracts\Formatter;

/**
 * @implements Formatter<int|string|\BackedEnum|null, \BackedEnum|null>
 */
class EnumFormatter implements Formatter
{
    /**
     * The backing enum for the entry.
     *
     * @var class-string<\BackedEnum>
     */
    protected $enum;

    /**
     * Set the backing enum for the entry.
     * 
     * @param  class-string<\BackedEnum>  $enum
     * @return $this
     */
    public function enum(string $enum): static
    {
        $this->enum = $enum;

        return $this;
    }

    /**
     * Get the backing enum for the entry.
     *
     * @return class-string<\BackedEnum>
     */
    public function getEnum(): string
    {
        return $this->enum;
    }

    /**
     * Check if the enum backing value is set.
     */
    public function hasEnum(): bool
    {
        return isset($this->enum);
    }

    /**
     * Check if the enum backing value is missing.
     */
    public function missingEnum(): bool
    {
        return ! $this->hasEnum();
    }

    /**
     * Format the value as an enum.
     * 
     * @param int|string|\BackedEnum|null $value
     * @return \BackedEnum|null
     */
    public function format(mixed $value): mixed
    {
        return match (true) {
            $this->missingEnum(),
            is_null($value) => null,
            $value instanceof \BackedEnum => $value,
            default => $this->getEnum()::tryFrom($value),
        };
    }
}