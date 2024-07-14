<?php

namespace Conquest\Chart\Shared\Concerns\Styling;

trait HasShadowOffsetY
{
    protected ?int $shadowOffsetY = null;

    public function shadowOffsetY(int $shadowOffsetY): self
    {
        $this->setShadowOffsetY($shadowOffsetY);
        return $this;
    }

    public function setShadowOffsetY(int|null $shadowOffsetY): void
    {
        if (is_null($shadowOffsetY)) return;
        
        $this->shadowOffsetY = $shadowOffsetY;
    }

    public function getShadowOffsetY(): ?int
    {
        return $this->shadowOffsetY;
    }
    
    public function lacksShadowOffsetY(): bool
    {
        return is_null($this->shadowOffsetY);
    }

    public function hasShadowOffsetY(): bool
    {
        return !$this->lacksShadowOffsetY();
    }

    public function getShadowOffsetYOption(): array
    {
        return $this->hasShadowOffsetY() ? [
            'shadowOffsetY' => $this->getShadowOffsetY()
        ] : [];
    
    }
    
}