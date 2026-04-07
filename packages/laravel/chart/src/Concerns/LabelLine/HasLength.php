<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\LabelLine;

trait HasLength
{
    /**
     * @var int|float|null
     */
    protected $length;

    /**
     * @return $this
     */
    public function length(int|float|null $value): static
    {
        $this->length = $value;

        return $this;
    }

    /**
     * @return int|float|null
     */
    public function getLength(): int|float|null
    {
        return $this->length;
    }
}
