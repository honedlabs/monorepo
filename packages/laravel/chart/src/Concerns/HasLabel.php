<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Label\Label;

trait HasLabel
{
    /**
     * The label.
     * 
     * @var \Honed\Chart\Label\Label|null
     */
    protected $label;

    /**
     * Set the label.
     * 
     * @param \Honed\Chart\Label\Label|(Closure(\Honed\Chart\Label\Label):\Honed\Chart\Label\Label)|null $value
     * @return $this
     */
    public function label(Label|Closure|null $value = null): static
    {
        $this->label = match (true) {
            is_null($value) => $this->withLabel(),
            $value instanceof Closure => $value($this->withLabel()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the label.
     * 
     * @return \Honed\Chart\Label\Label|null
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