<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Style\AreaStyle;

trait HasAreaStyle
{
    /**
     * The area style.
     * 
     * @var \Honed\Chart\Style\AreaStyle|null
     */
    protected $areaStyle;

    /**
     * Set the area style.
     * 
     * @param \Honed\Chart\Style\AreaStyle|(Closure(\Honed\Chart\Style\AreaStyle):\Honed\Chart\Style\AreaStyle)|null $value
     * @return $this
     */
    public function areaStyle(AreaStyle|Closure|null $value = null): static
    {
        $this->areaStyle = match (true) {
            is_null($value) => $this->withAreaStyle(),
            $value instanceof Closure => $value($this->withAreaStyle()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the area style.
     * 
     * @return \Honed\Chart\Style\AreaStyle|null
     */
    public function getAreaStyle(): ?AreaStyle
    {
        return $this->areaStyle;
    }

    /**
     * Create a new area style instance.
     */
    protected function withAreaStyle(): AreaStyle
    {
        return $this->areaStyle ??= AreaStyle::make();
    }
}