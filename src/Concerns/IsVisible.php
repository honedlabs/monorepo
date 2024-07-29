<?php

namespace Conquest\Core\Concerns;

use Closure;

trait IsVisible
{
    protected bool|Closure|null $visible = true;

    public function visible(bool|Closure $visible = true): static
    {
        $this->setVisible($visible);
        return $this;
    }

    public function setVisible(bool|Closure|null $visible): void
    {
        if (is_null($visible)) return;
        $this->visible = $visible;
    }

    public function isVisible(): bool
    {
        return $this->evaluate($this->visible);
    }

    public function isNotVisible(): bool
    {
        return !$this->isVisible();
    }
}