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
    public function array()
    {
        return $this->type(self::ARRAY);
    }

    /**
     * Set the type of the entry to boolean.
     *
     * @return $this
     */
    public function boolean()
    {
        return $this->type(self::BOOLEAN);
    }

    /**
     * Set the type of the entry to image.
     *
     * @return $this
     */
    public function image()
    {
        return $this->type(self::IMAGE);
    }

    /**
     * Set the type of the entry to numeric.
     *
     * @return $this
     */
    public function numeric()
    {
        return $this->type(self::NUMERIC);
    }

    /**
     * Set the type of the entry to text.
     *
     * @return $this
     */
    public function text()
    {
        return $this->type(self::TEXT);
    }

    /**
     * Determine if the entry is an array entry.
     *
     * @return bool
     */
    public function isArray()
    {
        return $this->getType() === self::ARRAY;
    }

    /**
     * Determine if the entry is a boolean entry.
     *
     * @return bool
     */
    public function isBoolean()
    {
        return $this->getType() === self::BOOLEAN;
    }

    /**
     * Determine if the entry is an image entry.
     *
     * @return bool
     */
    public function isImage()
    {
        return $this->getType() === self::IMAGE;
    }

    /**
     * Determine if the entry is a numeric entry.
     *
     * @return bool
     */
    public function isNumeric()
    {
        return $this->getType() === self::NUMERIC;
    }

    /**
     * Determine if the entry is a text entry.
     *
     * @return bool
     */
    public function isText()
    {
        return $this->getType() === self::TEXT;
    }

    /**
     * Format the value of the entry.
     *
     * @param  \Carbon\CarbonInterface|string|int|float|null  $value
     * @return mixed
     */
    public function format($value)
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
