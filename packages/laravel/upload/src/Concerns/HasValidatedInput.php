<?php

declare(strict_types=1);

namespace Honed\Upload\Concerns;

trait HasValidatedInput
{
    /**
     * The validated input.
     *
     * @var array<string, mixed>
     */
    protected $validated;

    /**
     * Set the validated input.
     *
     * @param  array<string, mixed>  $validated
     */
    public function setValidated(array $validated): void
    {
        $this->validated = $validated;
    }

    /**
     * Get the validated input.
     *
     * @return array<string, mixed>
     */
    public function getValidated(): array
    {
        return $this->validated;
    }
}