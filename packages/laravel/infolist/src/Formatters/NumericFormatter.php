<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Concerns\HasDecimals;
use Illuminate\Support\Number;
use Honed\Infolist\Contracts\Formatter;
use Honed\Infolist\Formatters\Support\LocalisedFormatter;

/**
 * @extends LocalisedFormatter<mixed, string>
 */
class NumericFormatter extends LocalisedFormatter
{
    use HasDecimals;

    /**
     * Whether to format the number as a file size.
     *
     * @var bool
     */
    protected $file = false;

    /**
     * Set whether to format the number as a file size.
     * 
     * @return $this
     */
    public function file(bool $value = true): static
    {
        $this->file = $value;

        return $this;
    }

    /**
     * Get whether the number should be formatted as a file size.
     */
    public function isFile(): bool
    {
        return $this->file;
    }

    /**
     * Format the value as a number.
     * 
     * @param mixed $value
     * @return string|null
     */
    public function format(mixed $value): mixed
    {
        if (! is_numeric($value)) {
            return null;
        }

        return match (true) {
            $this->isFile() => Number::fileSize(
                bytes: $value, 
                precision: $this->getDecimals() ?? 0
            ),
            default => Number::format(
                number: $value, 
                precision: $this->getDecimals(), 
                locale: $this->getLocale()
            ),
        };


    }
}