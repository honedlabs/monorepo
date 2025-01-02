<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

class BooleanFormatter implements Contracts\Formatter
{
    use Concerns\HasFalseLabel;
    use Concerns\HasTruthLabel;

    /**
     * Create a new boolean formatter instance with a truth label and false label.
     */
    public function __construct(?string $truth = null, ?string $false = null)
    {
        $this->setTruthLabel($truth);
        $this->setFalseLabel($false);
    }

    /**
     * Make a boolean formatter with a truth label and false label.
     */
    public static function make(?string $truth = null, ?string $false = null): static
    {
        return resolve(static::class, compact('truth', 'false'));
    }

    /**
     * Set the truth and false labels, chainable.
     *
     * @return $this
     */
    public function labels(?string $truth = null, ?string $false = null): static
    {
        $this->setTruthLabel($truth);
        $this->setFalseLabel($false);

        return $this;
    }

    /**
     * Format the value as a boolean
     */
    public function format(mixed $value): string
    {
        return ((bool) $value) ? $this->getTruthLabel() : $this->getFalseLabel();
    }
}
