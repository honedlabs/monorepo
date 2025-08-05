<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

/**
 * @internal
 */
trait CanKeepAspect
{
    /**
     * Whether to keep the aspect ratio.
     * 
     * @var bool|null
     */
    protected $keepAspect;

    /**
     * Set whether to keep the aspect ratio.
     * 
     * @return $this
     */
    public function keepAspect(bool $value = true): static
    {
        $this->keepAspect = $value;

        return $this;
    }

    /**
     * Set whether to not keep the aspect ratio.
     * 
     * @return $this
     */
    public function dontKeepAspect(bool $value = true): static
    {
        return $this->keepAspect(! $value);
    }

    /**
     * Get whether to keep the aspect ratio.
     */
    public function isKeepingAspect(): ?bool
    {
        return $this->keepAspect;
    }

    /**
     * Get whether to not keep the aspect ratio.
     */
    public function isNotKeepingAspect(): bool
    {
        return ! $this->keepAspect;
    }
}