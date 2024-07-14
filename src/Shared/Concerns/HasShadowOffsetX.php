<?php

namespace Conquest\Chart\Shared\Concerns;

trait HasShadowOffsetX
{
    protected ?int $shadowOffsetX = null;

    public function shadowOffsetX(int $shadowOffsetX): self
    {
        $this->setShadowOffsetX($shadowOffsetX);
        return $this;
    }

    public function setShadowOffsetX(int|null $shadowOffsetX): void
    {
        if (is_null($shadowOffsetX)) return;
        
        $this->shadowOffsetX = $shadowOffsetX;
    }

    public function getShadowOffsetX(): ?int
    {
        return $this->shadowOffsetX;
    }
    
    public function lacksShadowOffsetX(): bool
    {
        return is_null($this->shadowOffsetX);
    }

    public function hasShadowOffsetX(): bool
    {
        return !$this->lacksShadowOffsetX();
    }

    public function getShadowOffsetXOption(): array
    {
        return $this->hasShadowOffsetX() ? [
            'shadowOffsetX' => $this->getShadowOffsetX()
        ] : [];
    
    }
    
}