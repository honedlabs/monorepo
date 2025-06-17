<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

trait CanBeAggregated
{
    use CanBeArray;
    use CanBeBoolean;
    use CanBeDateTime;
    use CanBeImage;
    use CanBeNumeric;
    use CanBeText;

    /**
     * Set the type of the entry to array.
     *
     * @return $this
     */
    public function array(): static
    {
        return $this->type(self::ARRAY);
    }

    /**
     * Set the type of the entry to boolean.
     *
     * @return $this
     */
    public function boolean(): static
    {
        return $this->type(self::BOOLEAN);
    }

    /**
     * Set the type of the entry to image.
     *
     * @return $this
     */
    public function image(): static
    {
        return $this->type(self::IMAGE);
    }

    /**
     * Set the type of the entry to numeric.
     *
     * @return $this
     */
    public function numeric(): static
    {
        return $this->type(self::NUMERIC);
    }

    /**
     * Set the type of the entry to text.
     *
     * @return $this
     */
    public function text(): static
    {
        return $this->type(self::TEXT);
    }

    /**
     * Determine if the entry is an array entry.
     */
    public function isArray(): bool
    {
        return $this->getType() === self::ARRAY;
    }

    /**
     * Determine if the entry is a boolean entry.
     */
    public function isBoolean(): bool
    {
        return $this->getType() === self::BOOLEAN;
    }

    /**
     * Determine if the entry is an image entry.
     */
    public function isImage(): bool
    {
        return $this->getType() === self::IMAGE;
    }

    /**
     * Determine if the entry is a numeric entry.
     */
    public function isNumeric(): bool
    {
        return $this->getType() === self::NUMERIC;
    }

    /**
     * Determine if the entry is a text entry.
     */
    public function isText(): bool
    {
        return $this->getType() === self::TEXT;
    }

    /**
     * Format the value of the entry.
     *
     * @param  \Carbon\CarbonInterface|string|int|float|null  $value
     */
    public function format(mixed $value): mixed
    {
        if (is_null($value)) {
            return null;
        }

        return match (true) {
            $this->isArray() => $this->formatArray($value), // @phpstan-ignore argument.type
            $this->isBoolean() => $this->formatBoolean($value),
            $this->isDate() => $this->formatDate($value),
            $this->isDateTime() => $this->formatDateTime($value),
            $this->isTime() => $this->formatTime($value),
            $this->isImage() => $this->formatImage($value), // @phpstan-ignore argument.type
            $this->isNumeric() => $this->formatNumeric($value),
            $this->isText() => $this->formatText($value),
            default => $value,
        };
    }
}
