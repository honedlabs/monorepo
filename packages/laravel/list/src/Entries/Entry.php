<?php

declare(strict_types=1);

namespace Honed\List\Entries;

class Entry extends BaseEntry
{
    use Concerns\CanBeArray;
    use Concerns\CanBeBoolean;
    use Concerns\CanBeDate;
    use Concerns\CanBeImage;
    use Concerns\CanBeNumeric;
    use Concerns\CanBeText;

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
     * 
     * @return bool
     */
    public function isArray(): bool
    {
        return $this->getType() === self::ARRAY;
    }

    /**
     * Determine if the entry is a boolean entry.
     * 
     * @return bool
     */
    public function isBoolean(): bool
    {
        return $this->getType() === self::BOOLEAN;
    }

    /**
     * Determine if the entry is an image entry.
     * 
     * @return bool
     */
    public function isImage(): bool
    {
        return $this->getType() === self::IMAGE;
    }

    /**
     * Determine if the entry is a numeric entry.
     * 
     * @return bool
     */
    public function isNumeric(): bool
    {
        return $this->getType() === self::NUMERIC;
    }

    /**
     * Determine if the entry is a text entry.
     * 
     * @return bool
     */
    public function isText(): bool
    {
        return $this->getType() === self::TEXT;
    }

    /**
     * Format the value of the entry.
     * 
     * @param  mixed  $value
     * @return mixed
     */
    public function format(mixed $value): mixed
    {
        if (is_null($value)) {
            return null;
        }

        return match (true) {
            $this->isArray() => $this->formatArray($value),
            $this->isBoolean() => $this->formatBoolean($value),
            $this->isDate() => $this->formatDate($value),
            $this->isDateTime() => $this->formatDateTime($value),
            $this->isTime() => $this->formatTime($value),
            $this->isSince() => $this->formatSince($value),
            $this->isImage() => $this->formatImage($value),
            $this->isNumeric() => $this->formatNumeric($value),
            $this->isText() => $this->formatText($value),
            default => $value,
        };
    }
}