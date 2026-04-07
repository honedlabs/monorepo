<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\LabelLine;

trait HasLength2
{
    /**
     * @var int|float|null
     */
    protected $length2;

    /**
     * @return $this
     */
    public function length2(int|float|null $value): static
    {
        $this->length2 = $value;

        return $this;
    }

    /**
     * @return int|float|null
     */
    public function getLength2(): int|float|null
    {
        return $this->length2;
    }
}
