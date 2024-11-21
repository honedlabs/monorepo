<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns\Formatters;

use Closure;

trait HasFalseLabel
{
    protected string|Closure $falseLabel = 'No';

    public function falseLabel(string|Closure $falseLabel): static
    {
        $this->setFalseLabel($falseLabel);

        return $this;
    }

    public function setFalseLabel(string|Closure|null $falseLabel): void
    {
        if (is_null($falseLabel)) {
            return;
        }
        $this->falseLabel = $falseLabel;
    }

    public function getFalseLabel(): string
    {
        return $this->evaluate($this->falseLabel) ?? config('table.fallback.false', 'No');
    }
}
