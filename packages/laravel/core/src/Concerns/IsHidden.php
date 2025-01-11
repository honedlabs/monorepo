<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsHidden
{
    /**
     * @var bool
     */
    protected $hidden = false;

    /**
     * Set the instance as hidden.
     *
     * @return $this
     */
    public function hidden(bool $hidden = true): static
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Set the instance as shown.
     *
     * @return $this
     */
    public function shown(bool $shown = true): static
    {
        return $this->hidden(! $shown);
    }

    /**
     * Determine if the instance is hidden.
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }
}
