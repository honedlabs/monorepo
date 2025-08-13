<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

/**
 * @internal
 */
trait HasAlpha
{
    /**
     * The alpha component of the color.
     *
     * @var int
     */
    protected $alpha = 1;

    /**
     * Set the alpha component of the color.
     *
     * @return $this
     */
    public function alpha(int $alpha): static
    {
        $this->alpha = $alpha;

        return $this;
    }

    /**
     * Get the alpha component of the color.
     */
    public function getAlpha(): int
    {
        return $this->alpha;
    }
}
