<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsHidden
{
    /**
     * @var bool
     */
    protected $hidden = false;

    /**
     * Set the hidden property, chainable.
     *
     * @return $this
     */
    public function hidden(bool $hidden = true): static
    {
        $this->setHidden($hidden);

        return $this;
    }

    /**
     * Set as hidden, chainable.
     *
     * @return $this
     */
    public function hide(bool $hidden = true): static
    {
        return $this->hidden($hidden);
    }

    /**
     * Set as not hidden, chainable.
     *
     * @return $this
     */
    public function show(bool $hidden = false): static
    {
        return $this->hidden($hidden);
    }

    /**
     * Set the hidden property quietly.
     */
    public function setHidden(bool|null $hidden): void
    {
        if (\is_null($hidden)) {
            return;
        }
        $this->hidden = $hidden;
    }

    /**
     * Determine if the class is hidden.
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }
}
