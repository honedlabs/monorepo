<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Axis\Polar\Polar;

trait CanBePolar
{
    /**
     * The polar coordinate.
     *
     * @var \Honed\Chart\Polar\Polar|null
     */
    protected $polar;

    /**
     * Set a polar coordinate to be used.
     *
     * @param  \Honed\Chart\Polar\Polar|(Closure(\Honed\Chart\Polar\Polar):mixed)|null  $value
     * @return $this
     */
    public function polar(Polar|Closure|null $value): static
    {
        return match (true) {
            is_null($value) => $this->newPolar(),
            $value instanceof Closure => $value($this->newPolar()),
            default => $value,
        };
    }

    /**
     * Get the polar coordinate.
     *
     * @return \Honed\Chart\Polar\Polar|null
     */
    public function getPolar(): ?Polar
    {
        return $this->polar;
    }

    /**
     * Create a new polar coordinate, or use the existing one.
     */
    protected function newPolar(): Polar
    {
        return $this->polar ??= Polar::make();
    }
}
