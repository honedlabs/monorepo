<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

use Honed\Chart\Enums\Symbol;

/**
 * @internal
 */
trait HasSymbol
{
    /**
     * The symbol.
     *
     * @var string|array{0: string, 1: string}|null
     */
    protected $symbol;

    /**
     * Set the symbol.
     *
     * @param  string|Symbol|array{0: string|Symbol, 1: string|Symbol}|null  $value
     * @return $this
     */
    public function symbol(string|Symbol|array|null $value): static
    {
        $this->symbol = match (true) {
            $value instanceof Symbol => $value->value,
            is_array($value) => array_map(
                static fn (string|Symbol $item) => is_string($item) ? $item : $item->value,
                $value,
            ),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the symbol.
     *
     * @return string|array{0: string, 1: string}|null
     */
    public function getSymbol(): string|array|null
    {
        return $this->symbol;
    }
}
