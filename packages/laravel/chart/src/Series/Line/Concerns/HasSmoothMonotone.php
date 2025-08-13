<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Line\Concerns;

use Honed\Chart\Axis\Axis;

/**
 * @internal
 */
trait HasSmoothMonotone
{
    /**
     * The direction in which the broken line keeps the monotonicity.
     *
     * @var string|null
     */
    protected $smoothMonotone;

    /**
     * Set the direction in which the broken line keeps the monotonicity.
     *
     * @param  'x'|'y'  $value
     * @return $this
     */
    public function smoothMonotone(string $value): static
    {
        $this->smoothMonotone = $value;

        return $this;
    }

    /**
     * Set the direction in which the broken line keeps the monotonicity to be x.
     *
     * @return $this
     */
    public function smoothInX(): static
    {
        return $this->smoothMonotone(Axis::X);
    }

    /**
     * Set the direction in which the broken line keeps the monotonicity to be y.
     *
     * @return $this
     */
    public function smoothInY(): static
    {
        return $this->smoothMonotone(Axis::Y);
    }

    /**
     * Get the direction in which the broken line keeps the monotonicity.
     */
    public function getSmoothMonotone(): ?string
    {
        return $this->smoothMonotone;
    }
}
