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
     * @var LabelLayout|null
     */
    protected $labelLayout;

    /**
     * Set the label.
     *
     * @param  LabelLayout|(Closure(LabelLayout):LabelLayout)|null  $value
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
     */
    public function getLabelLayout(): ?LabelLayout
    {
        return $this->labelLayout;
    }

    /**
     * Create a new label instance.
     */
    protected function withLabelLayout(): LabelLayout
    {
        return $this->labelLayout ??= LabelLayout::make();
    }
}
