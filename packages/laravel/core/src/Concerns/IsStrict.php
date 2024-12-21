<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsStrict
{
    /**
     * @var bool|(\Closure():bool)
     */
    protected $strict = false;

    /**
     * Set whether the class is strict matching, chainable.
     *
     * @param  bool|\Closure():bool  $strict
     * @return $this
     */
    public function strict(bool|\Closure $strict = true): static
    {
        $this->setStrict($strict);

        return $this;
    }

    /**
     * Set whether the class is strict matching quietly.
     *
     * @param  bool|(\Closure():bool)|null  $strict
     */
    public function setStrict(bool|\Closure|null $strict): void
    {
        if (is_null($strict)) {
            return;
        }
        $this->strict = $strict;
    }

    /**
     * Determine if the class is strict matching.
     */
    public function isStrict(): bool
    {
        return (bool) $this->evaluate($this->strict);
    }

    /**
     * Determine if the class is not strict matching.
     */
    public function isNotStrict(): bool
    {
        return ! $this->isStrict();
    }
}
