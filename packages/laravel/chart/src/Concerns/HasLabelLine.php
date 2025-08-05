<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Label\LabelLine;

trait HasLabelLine
{
    /**
     * The label line.
     * 
     * @var \Honed\Chart\Label\LabelLine|null
     */
    protected $labelLine;

    /**
     * Set the label line.
     * 
     * @param \Honed\Chart\Label\LabelLine|(Closure(\Honed\Chart\Label\LabelLine):\Honed\Chart\Label\LabelLine)|null $value
     * @return $this
     */
    public function labelLine(LabelLine|Closure|null $value = null): static
    {
        $this->labelLine = match (true) {
            is_null($value) => $this->withLabelLine(),
            $value instanceof Closure => $value($this->withLabelLine()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the label line.
     */
    public function getLabelLine(): ?LabelLine
    {
        return $this->labelLine;
    }

    /**
     * Create a new label line instance.
     */
    protected function withLabelLine(): LabelLine
    {
        return $this->labelLine ??= LabelLine::make();
    }
}