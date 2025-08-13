<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Line\Concerns;

use Honed\Chart\Enums\CoordinateSystem;
use ValueError;

trait HasCoordinateSystem
{
    /**
     * The coordinate system of the line.
     *
     * @var CoordinateSystem|null
     */
    protected $coordinateSystem;

    /**
     * Set the coordinate system.
     *
     * @return $this
     *
     * @throws ValueError if the coordinate system is not a valid coordinate system
     */
    public function coordinateSystem(CoordinateSystem|string $coordinateSystem): static
    {
        if (! $coordinateSystem instanceof CoordinateSystem) {
            $coordinateSystem = CoordinateSystem::from($coordinateSystem);
        }

        $this->coordinateSystem = $coordinateSystem;

        return $this;
    }

    /**
     * Set the coordinate system to cartesian.
     *
     * @return $this
     */
    public function cartesian(): static
    {
        return $this->coordinateSystem(CoordinateSystem::Cartesian);
    }

    /**
     * Set the coordinate system to polar.
     *
     * @return $this
     */
    public function polar(): static
    {
        return $this->coordinateSystem(CoordinateSystem::Polar);
    }

    /**
     * Get the coordinate system of the line.
     */
    public function getCoordinateSystem(): ?string
    {
        return $this->coordinateSystem?->value;
    }
}
