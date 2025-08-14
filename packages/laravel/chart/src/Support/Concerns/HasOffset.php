<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

trait HasOffset
{
    /**
     * The offset to the default position.
     *
     * @var int|array{0: int, 1:int}|null
     */
    protected $offset;

    /**
     * Set the offset.
     *
     * @param int|array{0: int, 1: int} $value
     * @return $this
     */
    public function offset(int|array $value): static
    {
        $this->offset = $value;

        return $this;
    }

    /**
     * Get the offset.
     *
     * @return int|array{0: int, 1: int}|null
     */
    public function getOffset(): int|array|null
    {
        return $this->offset;
    }
}
