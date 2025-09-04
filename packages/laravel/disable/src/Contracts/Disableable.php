<?php

declare(strict_types=1);

namespace Honed\Disable\Contracts;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
interface Disableable
{
    /**
     * Check if the model is disabled.
     */
    public function isDisabled(): bool;

    /**
     * Disable the model.
     *
     * @return $this
     */
    public function disable(bool $value = true);

    /**
     * Get the name of the "is_disabled" column.
     */
    public function getDisabledColumn(): ?string;

    /**
     * Get the name of the "disabled_at" column.
     */
    public function getDisabledAtColumn(): ?string;

    /**
     * Get the name of the "disabled_by" column.
     */
    public function getDisabledByColumn(): ?string;
}
