<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

trait CanBeAutofocused
{
    /**
     * Whether the component should be autofocused.
     *
     * @var bool
     */
    protected $autofocus = false;

    /**
     * Set the component to be autofocused.
     *
     * @return $this
     */
    public function autofocus(bool $value = true): static
    {
        $this->autofocus = $value;

        return $this;
    }

    /**
     * Set the component to not be autofocused
     *
     * @return $this
     */
    public function dontAutofocus(bool $value = true): static
    {
        return $this->autofocus(! $value);
    }

    /**
     * Determine if the component is autofocused.
     */
    public function isAutofocused(): bool
    {
        return $this->autofocus;
    }

    /**
     * Determine if the component is not autofocused.
     */
    public function isNotAutofocused(): bool
    {
        return ! $this->isAutofocused();
    }
}
