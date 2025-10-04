<?php

declare(strict_types=1);

namespace Honed\Infolist\Contracts;

use Illuminate\Database\Eloquent\Model;

interface Entryable
{
    /**
     * Convert the class to an entry.
     *
     * @return array<string, mixed>
     */
    public function entry(): array;

    /**
     * Set the record to be used to generate a state.
     *
     * @param  array<string, mixed>|Model|null  $record
     * @return $this
     */
    public function record(array|Model|null $record): static;

    /**
     * Determine if the parameters pass the allow condition.
     *
     * @param  array<string, mixed>  $parameters
     * @param  array<string, mixed>  $typed
     */
    public function isAllowed(array $parameters = [], array $typed = []): bool;
}
