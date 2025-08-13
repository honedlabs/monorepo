<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

/**
 * @internal
 */
trait HasSymbolOffset
{
    /**
     * The offset of the symbol relative to the original position.
     *
     * @var array{int, int}|null
     */
    protected $symbolOffset;

    /**
     * Set the offset of the symbol relative to the original position.
     *
     * @param  array{0: int, 1: int}  $value
     * @return $this
     */
    public function symbolOffset(array $value): static
    {
        $this->symbolOffset = $value;

        return $this;
    }

    /**
     * Get the offset of the symbol relative to the original position.
     *
     * @return array{0: int, 1: int}|null
     */
    public function getSymbolOffset(): ?array
    {
        return $this->symbolOffset;
    }
}
