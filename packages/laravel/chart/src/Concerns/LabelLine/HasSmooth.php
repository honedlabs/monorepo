<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\LabelLine;

trait HasSmooth
{
    /**
     * @var bool|null
     */
    protected $smooth;

    /**
     * @return $this
     */
    public function smooth(bool $value = true): static
    {
        $this->smooth = $value;

        return $this;
    }

    public function getSmooth(): ?bool
    {
        return $this->smooth;
    }
}
