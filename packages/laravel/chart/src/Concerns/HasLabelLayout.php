<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Label\LabelLayout;

trait HasLabelLayout
{
    /**
     * The label.
     * 
     * @var \Honed\Chart\Label\LabelLayout|null
     */
    protected $labelLayout;

    /**
     * Set the label.
     * 
     * @param \Honed\Chart\Label\LabelLayout|(Closure(\Honed\Chart\Label\LabelLayout):\Honed\Chart\Label\LabelLayout)|null $value
     * @return $this
     */
    public function labelLayout(LabelLayout|Closure|null $value = null): static
    {
        $this->labelLayout = match (true) {
            is_null($value) => $this->withLabelLayout(),
            $value instanceof Closure => $value($this->withLabelLayout()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the label.
     * 
     * @return \Honed\Chart\Label\LabelLayout|null
     */
    public function getLabelLayout(): ?LabelLayout
    {
        return $this->label;
    }

    /**
     * Create a new label instance.
     */
    protected function withLabelLayout(): LabelLayout
    {
        return $this->labelLayout ??= LabelLayout::make();
    }
}