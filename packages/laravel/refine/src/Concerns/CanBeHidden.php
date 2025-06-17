<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

trait CanBeHidden
{
    /**
     * Whether the instance should be serialized.
     *
     * @var bool
     */
    protected bool $hidden = false;

    /**
     * Set whether the instance should be hidden from serialization
     *
     * @param  bool  $hidden
     * @return $this
     */
    public function hidden(bool $hidden = true): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Set whether the instance should not be hidden from serialization.
     *
     * @param  bool  $visible
     * @return $this
     */
    public function notHidden(bool $visible = true): self
    {
        return $this->hidden(! $visible);
    }

    /**
     * Set whether the instance should be visible when serializing.
     *
     * @param  bool  $visible
     * @return $this
     */
    public function visible(bool $visible = true): self
    {
        return $this->hidden(! $visible);
    }

    /**
     * Set whether the instance should not be visible when serializing.
     *
     * @param  bool  $hidden
     * @return $this
     */
    public function notVisible(bool $hidden = true): self
    {
        return $this->hidden($hidden);
    }

    /**
     * Get whether the instance is hidden from serialization.
     *
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * Get whether the instance is not hidden from serialization.
     *
     * @return bool
     */
    public function isNotHidden(): bool
    {
        return ! $this->isHidden();
    }

    /**
     * Get whether the instance is visible when serializing.
     *
     * @return bool
     */
    public function isVisible(): bool
    {
        return ! $this->isHidden();
    }

    /**
     * Get whether the instance is not visible when serializing.
     *
     * @return bool
     */
    public function isNotVisible(): bool
    {
        return $this->isHidden();
    }
}
