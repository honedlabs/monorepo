<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

/**
 * @internal
 */
trait HasZ
{
    /**
     * The z value of all graphical elements, used to control order of drawing graphical components.
     *
     * @var int|null
     */
    protected $z;

    /**
     * Set the z value of all graphical elements, used to control order of drawing graphical components.
     *
     * @return $this
     */
    public function z(?int $value): static
    {
        $this->z = $value;

        return $this;
    }

    /**
     * Get the z value of all graphical elements, used to control order of drawing graphical components.
     */
    public function getZ(): ?int
    {
        return $this->z;
    }
}
