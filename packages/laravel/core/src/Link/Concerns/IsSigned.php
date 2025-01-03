<?php

declare(strict_types=1);

namespace Honed\Core\Link\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsSigned
{
    /**
     * @var bool
     */
    protected $signed = false;

    /**
     * Set the url to be signed, chainable.
     *
     * @return $this
     */
    public function signed(bool $signed = true): static
    {
        $this->setSigned($signed);

        return $this;
    }

    /**
     * Set the url to be signed property quietly.
     */
    public function setSigned(bool $signed): void
    {
        $this->signed = $signed;
    }

    /**
     * Determine if the url should be signed.
     */
    public function isSigned(): bool
    {
        return $this->signed;
    }
}
