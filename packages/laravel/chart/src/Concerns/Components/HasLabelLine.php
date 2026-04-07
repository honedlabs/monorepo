<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\LabelLine;

trait HasLabelLine
{
    /**
     * @var ?LabelLine
     */
    protected $labelLineInstance;

    /**
     * @param  LabelLine|(Closure(LabelLine): LabelLine)|bool|null  $value
     * @return $this
     */
    public function labelLine(LabelLine|Closure|bool|null $value = true): static
    {
        $this->labelLineInstance = match (true) {
            $value => $this->withLabelLine(),
            $value instanceof Closure => $value($this->withLabelLine()),
            $value instanceof LabelLine => $value,
            default => null,
        };

        return $this;
    }

    public function getLabelLine(): ?LabelLine
    {
        return $this->labelLineInstance;
    }

    protected function withLabelLine(): LabelLine
    {
        return $this->labelLineInstance ??= LabelLine::make();
    }
}
