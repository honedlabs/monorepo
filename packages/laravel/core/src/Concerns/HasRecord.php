<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasRecord
{
    /**
     * The record to be used to generate a state.
     *
     * @var array<string, mixed>|Model|null
     */
    protected array|Model|null $record = null;

    /**
     * Set the record to be used to generate a state.
     *
     * @param  array<string, mixed>|Model|null  $record
     * @return $this
     */
    public function record(array|Model|null $record): static
    {
        $this->record = $record;

        return $this;
    }

    /**
     * Get the record to be used to generate a state.
     *
     * @return array<string, mixed>|Model|null
     */
    public function getRecord(): array|Model|null
    {
        return $this->record;
    }
}
