<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

trait IsHidden
{
    protected bool|Closure $hidden = false;

    public function hidden(bool|Closure $hidden = true): static
    {
        $this->setHidden($hidden);

        return $this;
    }

    public function hide(bool|Closure $hidden = true): static
    {
        return $this->hidden($hidden);
    }

    public function show(bool|Closure $hidden = false): static
    {
        return $this->hidden($hidden);
    }

    public function setHidden(bool|Closure|null $hidden): void
    {
        if (is_null($hidden)) {
            return;
        }
        $this->hidden = $hidden;
    }

    public function isHidden(): bool
    {
        return (bool) $this->evaluate($this->hidden);
    }

    public function IsNotHidden(): bool
    {
        return ! $this->isHidden();
    }
}
