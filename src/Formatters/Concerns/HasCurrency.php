<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasCurrency
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $currency = null;

    /**
     * Set the currency, chainable.
     *
     * @param string|(\Closure(mixed...):string) $currency
     * @return $this
     */
    public function currency(string|\Closure $currency): static
    {
        $this->setCurrency($currency);

        return $this;
    }

    /**
     * Set the currency quietly.
     *
     * @param string|(\Closure(mixed...):string)|null $currency
     */
    public function setCurrency(string|\Closure|null $currency): void
    {
        if (\is_null($currency)) {
            return;
        }

        $this->currency = $currency;
    }

    /**
     * Get the currency.
     * 
     * @param mixed $parameter
     * @return string|null
     */
    public function getCurrency($parameter = null): ?string
    {
        return value($this->currency, $parameter);
    }

    /**
     * Determine if the class does not have a currency.
     * 
     * @return bool
     */
    public function missingCurrency(): bool
    {
        return \is_null($this->currency);
    }

    /**
     * Determine if the class has a currency.
     *
     * @return bool
     */
    public function hasCurrency(): bool
    {
        return ! $this->missingCurrency();
    }
}
