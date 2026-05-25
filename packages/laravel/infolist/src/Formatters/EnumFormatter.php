<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use BackedEnum;
use Honed\Infolist\Contracts\Formatter;

/**
 * @implements Formatter<int|string|BackedEnum|null, BackedEnum|null>
 */
class EnumFormatter implements Formatter
{
    /**
     * The backing enum for the entry.
     *
     * @var class-string<BackedEnum>|null
     */
    protected $enum;

    /**
     * Set the backing enum for the entry.
     *
     * @param  class-string<BackedEnum>  $value
     * @return $this
     */
    public function enum(string $value): static
    {
        $this->enum = $value;

        return $this;
    }

    /**
     * Get the backing enum for the entry.
     *
     * @return class-string<BackedEnum>|null
     */
    public function getEnum(): ?string
    {
        return $this->enum;
    }

    /**
     * Format the value as an enum.
     *
     * @param  int|string|BackedEnum|null  $value
     * @return BackedEnum|null
     */
    public function format(mixed $value): mixed
    {
        $enum = $this->getEnum();

        return match (true) {
            is_null($enum), is_null($value) => null,
            $value instanceof BackedEnum => $value,
            default => $enum::tryFrom($value),
        };
    }
}
