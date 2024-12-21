<?php

namespace Conquest\Chart\Shared\AreaStyle\Concerns;

use Conquest\Chart\Shared\AreaStyle\AreaStyle;

trait HasAreaStyle
{
    public ?AreaStyle $areaStyle = null;

    // Enabler
    public function shaded(
        ?string $color = null,
        ?string $origin = null
    ): static {
        $this->enableAreaStyle();
        $this->areaStyle->setColor($color);
        $this->areaStyle->setOrigin($origin);

        return $this;
    }

    public function getAreaStyle(): ?AreaStyle
    {
        return $this->areaStyle;
    }

    public function getAreaStyleOptions(): array
    {
        return $this->hasAreaStyle() ? [
            'areaStyle' => $this->getAreaStyle()?->toArray(),
        ] : [];
    }

    public function lacksAreaStyle()
    {
        return is_null($this->areaStyle);
    }

    public function hasAreaStyle()
    {
        return ! $this->lacksAreaStyle();
    }

    protected function enableAreaStyle()
    {
        if ($this->lacksAreaStyle()) {
            $this->areaStyle = new AreaStyle();
        }
    }

    /** Access properties of area style */
}
