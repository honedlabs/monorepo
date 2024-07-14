<?php

namespace Conquest\Chart\Shared\Concerns\Styling;

trait HasOpacity
{
    protected ?float $opacity = null;

    public function opacity(float $opacity): self
    {
        $this->setOpacity($opacity);

        return $this;
    }

    public function setOpacity(?float $opacity): void
    {
        if (is_null($opacity)) {
            return;
        }
        if ($opacity < 0 || $opacity > 1) {
            return;
        }
        $this->opacity = $opacity;
    }

    public function getOpacity(): ?float
    {
        return $this->opacity;
    }

    public function lacksOpacity(): bool
    {
        return is_null($this->opacity);
    }

    public function hasOpacity(): bool
    {
        return ! $this->lacksOpacity();
    }

    public function getOpacityOption(): array
    {
        return $this->hasOpacity() ? [
            'opacity' => $this->getOpacity(),
        ] : [];

    }
}
