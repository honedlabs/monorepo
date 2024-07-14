<?php

namespace Conquest\Chart\Shared\Concerns;

trait ShouldScale
{
    protected bool $scale = true;

    public function scale(bool $scale = true): self
    {
        $this->setScale($scale);

        return $this;
    }

    public function setScale(?bool $scale): void
    {
        if (is_null($scale)) {
            return;
        }
        $this->scale = $scale;
    }

    public function isScale(): bool
    {
        return $this->scale;
    }

    public function isNotScale(): bool
    {
        return ! $this->isScale();
    }

    public function isScaleOption(): array
    {
        return $this->isNotScale() ? ['scale' => false] : [];
    }
}
