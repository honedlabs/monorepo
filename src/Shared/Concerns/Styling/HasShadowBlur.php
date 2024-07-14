<?php

namespace Conquest\Chart\Shared\Concerns\Styling;

trait HasShadowBlur
{
    protected ?int $shadowBlur = null;

    public function shadowBlur(int $shadowBlur): self
    {
        $this->setShadowBlur($shadowBlur);
        return $this;
    }

    public function setShadowBlur(int|null $shadowBlur): void
    {
        if (is_null($shadowBlur)) return;
        
        $this->shadowBlur = $shadowBlur;
    }

    public function getShadowBlur(): ?int
    {
        return $this->shadowBlur;
    }
    
    public function lacksShadowBlur(): bool
    {
        return is_null($this->shadowBlur);
    }

    public function hasShadowBlur(): bool
    {
        return !$this->lacksShadowBlur();
    }

    public function getShadowBlurOption(): array
    {
        return $this->hasShadowBlur() ? [
            'shadowBlur' => $this->getShadowBlur()
        ] : [];
    
    }
    
}