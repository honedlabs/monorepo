<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Label\Label;

/**
 * @phpstan-require-implements \Honed\Chart\Contracts\Chartable
 */
trait HasLabel
{
    /**
     * The label.
     *
     * @var ?Label
     */
    protected $label;

    /**
     * Set the label.
     *
     * @param  Label|(Closure(Label):Label)|bool|null  $value
     * @return $this
     */
    public function label(Label|Closure|bool|null $value = true): static
    {
        $this->label = match (true) {
            $value => $value,
            ! $value => null,
            is_null($value) => $this->withLabel(),
            $value instanceof Closure => $value($this->withLabel()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the label.
     */
    public function getLabel(): ?Label
    {
        return $this->label;
    }

    /**
     * Create a new label instance.
     */
    protected function withLabel(): Label
    {
        return $this->label ??= Label::make();
    }
}
