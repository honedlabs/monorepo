<?php

namespace Conquest\Chart\Shared\Concerns\Styling;

trait HasBorderWidth
{
    protected ?int $borderWidth = null;

    public function borderWidth(int $borderWidth): self
    {
        $this->setBorderWidth($borderWidth);
        return $this;
    }

    public function setBorderWidth(int|null $borderWidth): void
    {
        if (is_null($borderWidth)) return;
        
        $this->borderWidth = $borderWidth;
    }

    public function getBorderWidth(): ?int
    {
        return $this->borderWidth;
    }
    
    public function lacksBorderWidth(): bool
    {
        return is_null($this->borderWidth);
    }

    public function hasBorderWidth(): bool
    {
        return !$this->lacksBorderWidth();
    }

    public function getBorderWidthOption(): array
    {
        return $this->hasBorderWidth() ? [
            'borderWidth' => $this->getBorderWidth()
        ] : [];
    
    }
    
}