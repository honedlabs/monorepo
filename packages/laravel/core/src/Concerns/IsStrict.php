<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

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
    public function setStrict(bool $strict): void
    {
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
