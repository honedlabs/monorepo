<?php

namespace Conquest\Chart\Shared\Concerns\Styling;

trait HasColor
{
    protected ?string $color = null;

    public function color(string $color): self
    {
        $this->setColor($color);

        return $this;
    }

    public function setColor(?string $color): void
    {
        if (is_null($color)) {
            return;
        }

        $this->color = $color;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function lacksColor(): bool
    {
        return is_null($this->color);
    }

    public function hasColor(): bool
    {
        return ! $this->lacksColor();
    }

    public function getColorOption(): array
    {
        return $this->hasColor() ? [
            'color' => $this->getColor(),
        ] : [];

    }
}
