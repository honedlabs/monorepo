<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Line\Concerns;

/**
 * @internal
 */
trait CanBeNullConnected
{
    /**
     * Whether to connect across null values.
     * 
     * @var bool|null
     */
    protected $connectNulls;

    /**
     * Set whether to connect null values.
     * 
     * @return $this
     */
    public function connectNulls(bool $value = true): static
    {
        $this->connectNulls = $value;

        return $this;
    }

    /**
     * Set whether to not connect null values.
     * 
     * @return $this
     */
    public function dontConnectNulls(bool $value = true): static
    {
        return $this->connectNulls(! $value);
    }

    /**
     * Get whether to connect null values.
     * 
     * @return bool|null
     */
    public function isConnectingNulls(): ?bool
    {
        return $this->connectNulls ?: null;
    }

    /**
     * Get whether to not connect null values.
     */
    public function isNotConnectingNulls(): bool
    {
        return ! $this->isConnectingNulls();
    }
}