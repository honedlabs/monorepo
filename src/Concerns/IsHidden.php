<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsHidden
{
    /**
     * @var bool|(\Closure():bool)
     */
    protected $hidden = false;

    /**
     * Set the hidden property, chainable.
     * 
     * @param bool|(\Closure():bool) $hidden
     * @return $this
     */
    public function hidden(bool|\Closure $hidden = true): static
    {
        $this->setHidden($hidden);

        return $this;
    }

    /**
     * Set as hidden, chainable.
     * 
     * @param bool|(\Closure():bool) $hidden
     * @return $this
     */
    public function hide(bool|\Closure $hidden = true): static
    {
        return $this->hidden($hidden);
    }

    /**
     * Set as not hidden, chainable.
     * 
     * @param bool|(\Closure():bool) $hidden
     * @return $this
     */
    public function show(bool|\Closure $hidden = false): static
    {
        return $this->hidden($hidden);
    }

    /**
     * Set the hidden property quietly.
     * 
     * @param bool|(\Closure():bool)|null $hidden
     */
    public function setHidden(bool|\Closure|null $hidden): void
    {
        if (is_null($hidden)) {
            return;
        }
        $this->hidden = $hidden;
    }

    /**
     * Determine if the class is hidden.
     */
    public function isHidden(): bool
    {
        return (bool) $this->evaluate($this->hidden);
    }

    /**
     * Determine if the class is not hidden.
     */
    public function isNotHidden(): bool
    {
        return ! $this->isHidden();
    }
}
