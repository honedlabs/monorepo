<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\LabelLine;

trait HasSmooth
{
    /**
     * Whether the label line is drawn with a smooth curve.
     *
     * @var bool|null
     */
    protected $smooth;

    /**
     * Set whether the label line is drawn with a smooth curve.
     *
     * @return $this
     */
    public function smooth(bool $value = true): static
    {
        $this->smooth = $value;

        return $this;
    }

    /**
     * Get whether the label line is drawn with a smooth curve.
     */
    public function getSmooth(): ?bool
    {
        return $this->smooth;
    }
}
