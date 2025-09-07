<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

use Honed\Chart\Enums\Location;

trait HasNameLocation
{
    /**
     * The location of the name.
     */
    protected $nameLocation;

    /**
     * Set the location of the name.
     * 
     * @return $this
     */
    public function nameLocation(string|Location $value): static
    {
        $this->nameLocation = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the location of the name to be start.
     * 
     * @return $this
     */
    public function nameLocationStart(): static
    {
        return $this->nameLocation(Location::Start);
    }

    /**
     * Set the location of the name to be center.
     * 
     * @return $this
     */
    public function nameLocationCenter(): static
    {
        return $this->nameLocation(Location::Center);
    }

    /**
     * Set the location of the name to be end.
     * 
     * @return $this
     */
    public function nameLocationEnd(): static
    {
        return $this->nameLocation(Location::End);
    }

    /**
     * Get the location of the name.
     */
    public function getNameLocation(): ?string
    {
        return $this->nameLocation;
    }
}