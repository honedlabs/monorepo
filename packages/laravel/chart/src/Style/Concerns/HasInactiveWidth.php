<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasInactiveWidth
{
    /**
     * The width.
     *
     * @var int|string|null
     */
    protected $inactiveWidth;

    /**
     * Set the width.
     *
     * @return $this
     */
    public function inactiveWidth(int|string $value): static
    {
        $this->inactiveWidth = $value;

        return $this;
    }

    /**
     * Get the width.
     */
    public function getInactiveWidth(): int|string|null
    {
        return $this->inactiveWidth;
    }
}
