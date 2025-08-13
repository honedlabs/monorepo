<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Line\Concerns;

trait CanBeSmooth
{
    /**
     * @var bool|null
     */
    protected $smooth;

    public function smooth(bool $value = true): static
    {
        $this->smooth = $value;

        return $this;
    }

    public function notSmooth(bool $value = true): static
    {
        return $this->smooth(! $value);
    }

    /**
     * Determine if the line is smooth.
     *
     * @return true|null
     */
    public function isSmooth(): ?bool
    {
        return $this->smooth ?: null;
    }

    public function isNotSmooth(): bool
    {
        return ! $this->isSmooth();
    }
}
