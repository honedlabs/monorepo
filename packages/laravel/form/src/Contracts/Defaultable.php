<?php

declare(strict_types=1);

namespace Honed\Form\Contracts;

interface Defaultable
{
    /**
     * Set the default value.
     *
     * @return $this
     */
    public function defaultValue(mixed $value): static;

    /**
     * Get the default value.
     */
    public function getDefaultValue(): mixed;

    /**
     * Get the placeholder for when the given value is null.
     */
    public function empty(): mixed;
}
