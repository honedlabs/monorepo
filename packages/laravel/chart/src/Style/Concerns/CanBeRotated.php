<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

/**
 * @internal
 */
trait CanBeRotated
{
    /**
     * The rotation in degrees.
     *
     * @var int|null
     */
    protected $rotate;

    /**
     * Set the rotation in degrees.
     *
     * @return $this
     */
    public function rotate(int $value): static
    {
        $this->rotate = $value;

        return $this;
    }

    /**
     * Set the rotation in degrees.
     *
     * @return $this
     *
     * @see \Honed\Chart\Style\Concerns\CanBeRotated::rotate()
     */
    public function rotation(int $value): static
    {
        return $this->rotate($value);
    }

    /**
     * Get the rotation in degrees.
     */
    public function getRotation(): ?int
    {
        return $this->rotate;
    }
}
