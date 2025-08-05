<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

/**
 * @internal
 */
trait HasSymbolSize
{
    /**
     * Symbol size at the two ends of the mark line. It can be an array for two ends, or assigned separately.
     * 
     * @var int|array{int, int}|null
     */
    protected $symbolSize;

    /**
     * Set the symbol size.
     * 
     * @param int|array{int, int}|null $value
     * @return $this
     */
    public function symbolSize(int|array $value): static
    {
        $this->symbolSize = $value;

        return $this;
    }

    /**
     * Get the symbol size.
     * 
     * @return int|array{int, int}|null
     */
    public function getSymbolSize(): int|array|null
    {
        return $this->symbolSize;
    }
}