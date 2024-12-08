<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

class BooleanFormatter implements Contracts\Formatter
{
    use Concerns\HasFalseLabel;
    use Concerns\HasTruthLabel;

    /**
     * Create a new boolean formatter instance with a truth label and false label.
     *
     * @param  string|(\Closure():string)|null  $truthLabel
     * @param  string|(\Closure():string)|null  $falseLabel
     */
    public function __construct(string|\Closure|null $truthLabel = null, string|\Closure|null $falseLabel = null)
    {
        $this->setTruthLabel($truthLabel);
        $this->setFalseLabel($falseLabel);
    }

    /**
     * Make a boolean formatter with a truth label and false label.
     *
     * @param  string|(\Closure():string)|null  $truthLabel
     * @param  string|(\Closure():string)|null  $falseLabel
     * @return $this
     */
    public static function make(string|\Closure|null $truthLabel = null, string|\Closure|null $falseLabel = null): static
    {
        return resolve(static::class, compact('truthLabel', 'falseLabel'));
    }

    /**
     * Set the truth and false labels, chainable.
     *
     * @param  string|(\Closure():string)|null  $truthLabel
     * @param  string|(\Closure():string)|null  $falseLabel
     * @return $this
     */
    public function labels(string|\Closure|null $truthLabel = null, string|\Closure|null $falseLabel = null): static
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
        return (bool) $value ? $this->getTruthLabel() : $this->getFalseLabel();
    }
}
