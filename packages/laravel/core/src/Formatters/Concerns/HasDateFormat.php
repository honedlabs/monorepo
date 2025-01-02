<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasDateFormat
{
    const DefaultDateFormat = 'd/m/Y';

    /**
     * @var string|null
     */
    protected $dateFormat = null;

    /**
     * @var string
     */
    protected static $defaultDateFormat = self::DefaultDateFormat;

    /**
     * Configure the default date format.
     */
    public static function useDateFormat(?string $dateFormat = null): void
    {
        static::$defaultDateFormat = $dateFormat ?? self::DefaultDateFormat;
    }

    /**
     * Get the default date format.
     */
    public static function getDefaultDateFormat(): string
    {
        return static::$defaultDateFormat;
    }

    /**
     * Set the dateFormat, chainable.
     *
     * @return $this
     */
    public function dateFormat(string $dateFormat): static
    {
        $this->setDateFormat($dateFormat);

        return $this;
    }

    /**
     * Set the dateFormat quietly.
     */
    public function setDateFormat(?string $dateFormat): void
    {
        if (\is_null($dateFormat)) {
            return;
        }

        $this->dateFormat = $dateFormat;
    }

    /**
     * Get the dateFormat.
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat ?? static::getDefaultDateFormat();
    }

    /**
     * Set the date format to d M Y
     *
     * @return $this
     */
    public function dMY(string $separator = '/'): static
    {
        return $this->dateFormat("d{$separator}M{$separator}Y");
    }

    /**
     * Set the date format to Y-m-d
     *
     * @return $this
     */
    public function Ymd(string $separator = '-'): static
    {
        return $this->dateFormat("Y{$separator}m{$separator}d");
    }
}
