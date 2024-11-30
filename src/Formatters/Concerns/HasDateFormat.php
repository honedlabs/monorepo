<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasDateFormat
{
    /**
     * @var string|(\Closure():string)
     */
    protected $dateFormat = 'd/m/y';

    /**
     * Set the dateFormat, chainable.
     *
     * @param string|(\Closure():string) $dateFormat
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
     * @param string|(\Closure():string)|null $dateFormat
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
     * @param mixed $parameter
     * @return string
     */
    public function getDateFormat($parameter = null): string
    {
        return value($this->dateFormat, $parameter);
    }
}
