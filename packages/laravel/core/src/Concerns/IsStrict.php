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
     * Set the instance as strict.
     *
     * @return $this
     */
    public function strict(bool $strict = true): static
    {
        $this->strict = $strict;

        return $this;
    }

    /**
     * Set the instance as relaxed.
     *
     * @return $this
     */
    public function relaxed(bool $relaxed = true): static
    {
        return $this->strict(! $relaxed);
    }

    /**
     * Determine if the instance is strict.
     */
    public function isStrict(): bool
    {
        return $this->strict;
    }
}
