<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasBorderRadius
{
    /**
     * The radius of the rounded corner in px.
     * 
     * @var int|array<int, int>|null
     */
    protected $borderRadius;

    /**
     * Set the radius of the rounded corner in pixels.
     * 
     * @param int|array<int, int> $value
     * @return $this
     */
    public function borderRadius(int|array $value): static
    {
        $this->borderRadius = $value;

        return $this;
    }

    /**
     * Get the radius of the rounded corner in pixels.
     * 
     * @return int|array<int, int>|null
     */
    public function getBorderRadius(): int|array|null
    {
        return $this->borderRadius;
    }
}