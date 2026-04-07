<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Label;

trait HasLabel
{
    /**
     * The label.
     *
     * @var ?Label
     */
    protected $labelInstance;

    /**
     * Set the label.
     *
     * @param  Label|(Closure(Label):Label)|bool|null  $value
     * @return $this
     */
    public function label(Label|Closure|bool|null $value = true): static
    {
        $this->labelInstance = match (true) {
            $value => $this->withLabel(),
            $value instanceof Closure => $value($this->withLabel()),
            $value instanceof Label => $value,
            default => null,
        };

        return $this;
    }

    /**
     * Get the label.
     */
    public function getLabel(): ?Label
    {
        return $this->labelInstance;
    }

    /**
     * Create a new label instance.
     */
    protected function withLabel(): Label
    {
        return $this->labelInstance ??= Label::make();
    }
}
