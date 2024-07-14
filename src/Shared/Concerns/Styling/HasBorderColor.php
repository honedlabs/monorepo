<?php

namespace Conquest\Chart\Shared\Concerns\Styling;

trait HasBorderColor
{
    protected ?string $borderColor = null;

    public function borderColor(string $borderColor): self
    {
        $this->setBorderColor($borderColor);

        return $this;
    }

    public function setBorderColor(?string $borderColor): void
    {
        if (is_null($borderColor)) {
            return;
        }

        $this->borderColor = $borderColor;
    }

    public function getBorderColor(): ?string
    {
        return $this->borderColor;
    }

    public function lacksBorderColor(): bool
    {
        return is_null($this->borderColor);
    }

    public function hasBorderColor(): bool
    {
        return ! $this->lacksBorderColor();
    }

    public function getBorderColorOption(): array
    {
        return $this->hasBorderColor() ? [
            'borderColor' => $this->getBorderColor(),
        ] : [];

    }
}
