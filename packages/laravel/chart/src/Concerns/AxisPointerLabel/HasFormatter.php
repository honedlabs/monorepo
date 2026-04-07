<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointerLabel;

trait HasFormatter
{
    /**
     * @var string|null
     */
    protected $formatter;

    /**
     * @return $this
     */
    public function formatter(?string $value): static
    {
        $this->formatter = $value;

        return $this;
    }

    public function getFormatter(): ?string
    {
        return $this->formatter;
    }
}
