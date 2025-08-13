<?php

declare(strict_types=1);

namespace Honed\Chart\Calendar\Concerns;

/**
 * @internal
 */
trait HasRange
{
    /**
     * The range of coordinates.
     *
     * @var int|string|array<int, int|string>|null
     */
    protected $range;

    /**
     * Set the range of coordinates.
     *
     * @param  int|string|array<int, int|string>|null  $value
     * @return $this
     */
    public function range(int|string|array $value): static
    {
        $this->range = $value;

        return $this;
    }

    /**
     * Get the range of coordinates.
     *
     * @return int|string|array<int, int|string>|null
     */
    public function getRange(): int|string|array|null
    {
        return $this->range;
    }
}
