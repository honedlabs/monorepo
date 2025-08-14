<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

/**
 * @internal
 */
trait HasRotation
{
    /**
     * The rotation in degrees.
     *
     * @var int|null
     */
    protected $rotation;

    /**
     * Set the rotation in degrees.
     *
     * @return $this
     */
    public function rotation(int $value): static
    {
        $this->rotation = $value;

        return $this;
    }

    /**
     * Set the rotation in degrees.
     *
     * @return $this
     *
     * @see \Honed\Chart\Support\Concerns\HasRotation::rotation()
     */
    public function rotate(int $value): static
    {
        return $this->rotation($value);
    }

    /**
     * Get the rotation in degrees.
     */
    public function getRotation(): ?int
    {
        return $this->rotation;
    }
}
