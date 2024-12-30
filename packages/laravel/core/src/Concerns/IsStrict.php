<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsStrict
{
    /**
     * @var bool
     */
    protected $strict = false;

    /**
     * Set whether the class is strict matching, chainable.
     *
     * @return $this
     */
    public function strict(bool $strict = true): static
    {
        $this->setStrict($strict);

        return $this;
    }

    /**
     * Set whether the class is strict matching quietly.
     */
    public function setStrict(bool|null $strict): void
    {
        if (\is_null($strict)) {
            return;
        }

        $this->strict = $strict;
    }

    /**
     * Determine if the class is strict matching.
     */
    public function isStrict(): bool
    {
        return $this->strict;
    }
}
