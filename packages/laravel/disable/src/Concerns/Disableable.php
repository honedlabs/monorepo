<?php

declare(strict_types=1);

namespace Honed\Disable\Concerns;

use Honed\Disable\Support\Disable;
use Illuminate\Support\Facades\Auth;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait Disableable
{
    /**
     * Initialize the disableable trait.
     */
    public function initializeDisableable(): void
    {
        if (Disable::boolean()) {
            $this->mergeCasts([
                $this->getDisabledColumn() => 'boolean',
            ]);
        }
    }

    /**
     * Check if the model is disabled.
     */
    public function isDisabled(): bool
    {
        return true;
    }

    /**
     * Check if the model is not disabled.
     */
    public function isNotDisabled(): bool
    {
        return ! $this->isDisabled();
    }

    /**
     * Check if the model is enabled.
     */
    public function isEnabled(): bool
    {
        return ! $this->isDisabled();
    }

    /**
     * Check if the model is not enabled.
     */
    public function isNotEnabled(): bool
    {
        return ! $this->isEnabled();
    }

    /**
     * Disable the model.
     *
     * @return $this
     */
    public function disable(bool $value = true): static
    {
        $this->setDisabled($value);
        $this->setDisabledAt($value ? $this->freshTimestamp() : null);
        $this->setDisabledBy($value ? Auth::id() : null);

        return $this;
    }

    /**
     * Enable the model.
     *
     * @return $this
     */
    public function enable(bool $enabled = true): static
    {
        return $this->setEnabled($enabled);
    }

    /**
     * Set the value of the "is_disabled" attribute.
     *
     * @return $this
     */
    public function setDisabled(bool $value): static
    {
        $column = $this->getDisabledColumn();

        if (Disable::boolean() && ! is_null($column) && ! $this->isDirty($column)) {
            $this->{$column} = $value;
        }

        return $this;
    }

    /**
     * Set the value of the "disabled_at" attribute.
     *
     * @return $this
     */
    public function setDisabledAt(mixed $time): static
    {
        $column = $this->getDisabledAtColumn();

        if (Disable::timestamp() && ! is_null($column) && ! $this->isDirty($column)) {
            $this->{$column} = $time;
        }

        return $this;
    }

    /**
     * Set the value of the "disabled_by" attribute.
     *
     * @return $this
     */
    public function setDisabledBy(mixed $id): static
    {
        $column = $this->getDisabledByColumn();

        if (Disable::user() && ! is_null($column) && ! $this->isDirty($column)) {
            $this->{$column} = $id;
        }

        return $this;
    }

    /**
     * Get the name of the "is_disabled" column.
     */
    public function getDisabledColumn(): ?string
    {
        return defined('static::DISABLED') ? static::DISABLED : 'is_disabled';
    }

    /**
     * Get the name of the "disabled_at" column.
     */
    public function getDisabledAtColumn(): ?string
    {
        return defined('static::DISABLED_AT') ? static::DISABLED_AT : 'disabled_at';
    }

    /**
     * Get the name of the "disabled_by" column.
     */
    public function getDisabledByColumn(): ?string
    {
        return defined('static::DISABLED_BY') ? static::DISABLED_BY : 'disabled_by';
    }
}
