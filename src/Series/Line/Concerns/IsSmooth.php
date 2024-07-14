<?php

namespace Conquest\Chart\Series\Line\Concerns;

trait IsSmooth
{
    protected bool $smooth = false;

    public function smooth(bool $smooth = true): self
    {
        $this->setSmooth($smooth);

        return $this;
    }

    public function setSmooth(?bool $smooth): void
    {
        if (is_null($smooth)) {
            return;
        }

        $this->smooth = $smooth;
    }

    public function isSmooth(): bool
    {
        return $this->smooth;
    }

    public function isNotSmooth(): bool
    {
        return ! $this->isSmooth();
    }

    public function isSmoothOption(): array
    {
        return $this->isSmooth() ? ['smooth' => true] : [];
    }
}
