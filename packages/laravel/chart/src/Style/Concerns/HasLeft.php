<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasLeft
{
    /**
     * The distance from the left side of the container.
     * 
     * @var int|string|null
     */
    protected $left;

    public function left(int|string|null $value): static
    {
        $this->left = $value;

        return $this;
    }

    public function getLeft(): int|string|null
    {
        return $this->left;
    }
}