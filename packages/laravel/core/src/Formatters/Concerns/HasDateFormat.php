<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasDateFormat
{
    public const DefaultDateFormat = 'd/m/Y';

    /**
     * @var string|(\Closure():string)
     */
    protected $dateFormat = self::DefaultDateFormat;

    /**
     * Set the dateFormat, chainable.
     *
     * @param  string|(\Closure():string)  $dateFormat
     * @return $this
     */
    public function dateFormat(string|\Closure $dateFormat): static
    {
        $this->setDateFormat($dateFormat);

        return $this;
    }

    /**
     * Set the dateFormat quietly.
     *
     * @param  string|(\Closure():string)|null  $dateFormat
     */
    public function setDateFormat(string|\Closure|null $dateFormat): void
    {
        if (\is_null($dateFormat)) {
            return;
        }

        $this->dateFormat = $dateFormat;
    }

    /**
     * Get the dateFormat.
     *
     * @param  mixed  $parameter
     */
    public function getDateFormat($parameter = null): string
    {
        return value($this->dateFormat, $parameter);
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
