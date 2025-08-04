<?php

declare(strict_types=1);

namespace Honed\Chart\Title\Concerns;

/**
 * @internal
 */
trait HasSubtext
{
    /**
     * The main title subtext.
     * 
     * @var string|null
     */
    protected $subtext;

    /**
     * Set the main title subtext.
     * 
     * @return $this
     */
    public function subtext(?string $value): static
    {
        $this->subtext = $value;

        return $this;
    }

    /**
     * Get the main title subtext.
     */
    public function getSubtext(): ?string
    {
        return $this->subtext;
    }
}