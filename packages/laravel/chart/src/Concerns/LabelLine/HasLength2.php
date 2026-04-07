<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\LabelLine;

trait HasLength2
{
    /**
     * The length of the label line at the end.
     *
     * @var int|float|null
     */
    protected $length2;

    /**
     * Set the length of the label line at the end.
     *
     * @return $this
     */
    public function length2(int|float|null $value): static
    {
        $this->length2 = $value;

        return $this;
    }

    /**
     * Get the length of the label line at the end.
     */
    public function getLength2(): int|float|null
    {
        return $this->length2;
    }
}
