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
    public function __construct(string $truthLabel = null, string $falseLabel = null)
    {
        $this->setTruthLabel($truthLabel);
        $this->setFalseLabel($falseLabel);
    }

    /**
     * Make a boolean formatter with a truth label and false label.
     */
    public static function make(string $truthLabel = null, string $falseLabel = null): static
    {
        return resolve(static::class, compact('truthLabel', 'falseLabel'));
    }

    /**
     * Set the truth and false labels, chainable.
     * 
     * @return $this
     */
    public function labels(string $truthLabel = null, string $falseLabel = null): static
    {
        $this->setTruthLabel($truthLabel);
        $this->setFalseLabel($falseLabel);

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
