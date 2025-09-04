<?php

declare(strict_types=1);

namespace Honed\Disable\Contracts;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait Disableable
{
    public function isDisabled(): bool
    {
        return true;
    }

    public function isNotDisabled(): bool
    {
        return ! $this->isDisabled();
    }

    public function isEnabled(): bool
    {
        return ! $this->isDisabled();
    }

    public function isNotEnabled(): bool
    {
        return ! $this->isEnabled();
    }

    public function disable(bool $value = true): void
    {
        $this->setAttribute($this->getDisabledAttribute(), $value);

    }

    public function enable(bool $enabled = true): void
    {
        $this->setAttribute($this->getDisabledAttribute(), $enabled);
    }

    public function getDisabledAttribute(): string
    {
        // return defined('static::DISABLED')
    }
}