<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\AreaStyle;

trait HasAreaStyle
{
    /**
     * The area style.
     *
     * @var ?AreaStyle
     */
    protected $areaStyleInstance;

    /**
     * Set the area style.
     *
     * @param  AreaStyle|(Closure(AreaStyle):AreaStyle)|bool|null  $value
     * @return $this
     */
    public function areaStyle(AreaStyle|Closure|bool|null $value = true): static
    {
        $this->areaStyleInstance = match (true) {
            $value => $this->withAreaStyle(),
            ! $value => null,
            $value instanceof Closure => $value($this->withAreaStyle()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the area style.
     */
    public function getAreaStyle(): ?AreaStyle
    {
        return $this->areaStyleInstance;
    }

    /**
     * Create a new area style instance.
     */
    protected function withAreaStyle(): AreaStyle
    {
        return $this->areaStyleInstance ??= AreaStyle::make();
    }
}
