<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Line\Concerns;

/**
 * @internal
 */
trait CanConnectNulls
{
    /**
     * Whether to connect across null values.
     *
     * @var bool
     */
    protected $connectNulls = false;

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
     */
    public function isNullConnected(): bool
    {
        return $this->connectNulls;
    }

    /**
     * Get whether to not connect null values.
     */
    public function isNullDisconnected(): bool
    {
        return ! $this->isNullConnected();
    }
}
