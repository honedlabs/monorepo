<?php

namespace Conquest\Chart\Concerns;

trait HasColors
{
    /**
     * @property array<string> $colors
     */
    protected array $colors = [];

    public function colors(string|array $color): self
    {
        $this->setColors($color);
        return $this;
    }

    public function setColor(string|array|null $colors): void
    {
        if (is_null($colors)) return;
        if (is_string($colors)) $colors = [$colors];
        $this->colors = array_merge($this->colors, $colors);
    }

    public function getColors(): array
    {
        return $this->colors;
    }
    
    public function getColorsOption(): array
    {
        return count($this->getColors()) ? [
            'color' => $this->getColors()
        ] : [];
    }
}