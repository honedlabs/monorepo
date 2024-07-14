<?php

namespace Conquest\Chart\Shared\Concerns\Styling;

trait HasBorderRadius
{
    protected int|array|null $borderRadius = null;

    public function borderRadius(int|array $borderRadius): self
    {
        $this->setBorderRadius($borderRadius);
        return $this;
    }

    public function setBorderRadius(int|array|null $borderRadius): void
    {
        if (is_null($borderRadius)) return;
        
        $this->borderRadius = $borderRadius;
    }

    public function getBorderRadius(): int|array|null
    {
        return $this->borderRadius;
    }
    
    public function lacksBorderRadius(): bool
    {
        return is_null($this->borderRadius);
    }

    public function hasBorderRadius(): bool
    {
        return !$this->lacksBorderRadius();
    }

    public function getBorderRadiusOption(): array
    {
        return $this->hasBorderRadius() ? [
            'borderRadius' => $this->getBorderRadius()
        ] : [];
    
    }
    
}