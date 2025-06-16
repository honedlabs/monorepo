<?php

declare(strict_types=1);

namespace Honed\List\Entries;

class Entry extends BaseEntry
{
    use Concerns\CanBeDate;
    use Concerns\CanBeNumeric;
    use Concerns\CanBeText;
    use Concerns\CanBeImage;

    /**
     * Set the type of the entry to text.
     * 
     * @return $this
     */
    public function text(): static
    {
        return $this->type('text');
    }

    /**
     * Determine if the entry is a text entry.
     * 
     * @return bool
     */
    public function isText(): bool
    {
        return $this->getType() === 'text';
    }

    /**
     * Set the type of the entry to numeric.
     * 
     * @return $this
     */
    public function numeric(): static
    {
        return $this->type('numeric');
    }

    /**
     * Determine if the entry is a numeric entry.
     * 
     * @return bool
     */
    public function isNumeric(): bool
    {
        return $this->getType() === 'numeric';
    }

    /**
     * Set the type of the entry to image.
     * 
     * @return $this
     */
    public function image(): static
    {
        return $this->type('image');
    }

    /**
     * Determine if the entry is an image entry.
     * 
     * @return bool
     */
    public function isImage(): bool
    {
        return $this->getType() === 'image';
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
            $this->isDate() => $this->formatDate($value),
            $this->isTime() => $this->formatTime($value),
            $this->isDateTime() => $this->formatDateTime($value),
            $this->isSince() => $this->formatSince($value),
            $this->isImage() => $this->formatImage($value),
            $this->isNumeric() => $this->formatNumeric($value),
            $this->isText() => $this->formatText($value),
            default => $value,
        };
    }
}