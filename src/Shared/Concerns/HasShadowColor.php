<?php

namespace Conquest\Chart\Shared\Concerns;

trait HasShadowColor
{
    protected ?string $shadowColor = null;

    public function shadowColor(string $shadowColor): self
    {
        $this->setShadowColor($shadowColor);
        return $this;
    }

    public function setShadowColor(string|null $shadowColor): void
    {
        if (is_null($shadowColor)) return;
        
        $this->shadowColor = $shadowColor;
    }

    public function getShadowColor(): ?string
    {
        return $this->shadowColor;
    }
    
    public function lacksShadowColor(): bool
    {
        return is_null($this->shadowColor);
    }

    public function hasShadowColor(): bool
    {
        return !$this->lacksShadowColor();
    }

    public function getShadowColorOption(): array
    {
        return $this->hasShadowColor() ? [
            'shadowColor' => $this->getShadowColor()
        ] : [];
    
    }
    
}