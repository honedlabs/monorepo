<?php

declare(strict_types=1);

namespace Honed\Chart\Emphasis\Concerns;

/**
 * @internal
 */
trait CanBeDisabled
{
    /**
     * Whether to disable the emphasis state.
     * 
     * @var bool
     */
    protected $disabled = false;

    /**
     * Set whether to disable the emphasis state.
     * 
     * @return $this
     */
    public function disabled(bool $value = true): static
    {
        $this->disabled = $value;

        return $this;
    }

    /**
     * Set whether to not disable the emphasis state.
     * 
     * @return $this
     */
    public function dontDisable(bool $value = true): static
    {
        return $this->disabled(! $value);
    }

    /**
     * Get whether to disable the emphasis state.
     * 
     * @return bool|null
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * Get whether to not disable the emphasis state.
     * 
     * @return bool
     */
    public function isNotDisabled(): bool
    {
        return ! $this->isDisabled();
    }
}