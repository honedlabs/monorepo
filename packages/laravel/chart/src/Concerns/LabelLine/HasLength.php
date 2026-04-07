<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\LabelLine;

trait HasLength
{
    /**
     * The length of the label line from the start.
     *
     * @var int|float|null
     */
    protected $length;

    /**
     * Set the length of the label line.
     *
     * @return $this
     */
    public function length(int|float|null $value): static
    {
        $this->length = $value;

        return $this;
    }

    /**
     * Get the length of the label line.
     *
     * @return int|float|null
     */
    public function getLength(): int|float|null
    {
        return $this->length;
    }
}
