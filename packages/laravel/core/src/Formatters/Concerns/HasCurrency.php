<?php

declare(strict_types=1);

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */

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
     * @param  string|(\Closure(mixed...):string)  $currency
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
     * @param  string|(\Closure(mixed...):string)|null  $currency
     */
    public function setCurrency(string|\Closure|null $currency): void
    {
        if (\is_null($currency)) {
            return;
        }

        $this->currency = $currency;
    }

    /**
     * Get the currency using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getCurrency(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->currency, $named, $typed);
    }

    /**
     * Resolve the currency using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function resolveCurrency(array $named = [], array $typed = []): ?string
    {
        $currency = $this->getCurrency($named, $typed);
        $this->setCurrency($currency);

        return $currency;
    }

    /**
     * Determine if the class has a currency.
     */
    public function hasCurrency(): bool
    {
        return ! \is_null($this->currency);
    }
}
