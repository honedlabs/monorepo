<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Facades\URL;

trait CanHaveTarget
{
    /**
     * The target for the URL
     *
     * @var string|null
     */
    protected $target;

    /**
     * Set the target for the URL.
     *
     * @return $this
     */
    public function target(?string $target): static
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Open the URL in a new tab.
     *
     * @return $this
     */
    public function openUrlInNewTab(): static
    {
        return $this->target('_blank');
    }

    /**
     * Get the target for the URL.
     */
    public function getTarget(): ?string
    {
        return $this->target;
    }
}
