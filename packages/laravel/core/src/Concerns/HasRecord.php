<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasRecord
{
    /**
     * The record to be used to generate a state.
     *
     * @var array<string, mixed>|\Illuminate\Database\Eloquent\Model|null
     */
    protected $record = null;

    /**
     * Set the record to be used to generate a state.
     *
     * @param  array<string, mixed>|\Illuminate\Database\Eloquent\Model  $record
     * @return $this
     */
    public function record($record)
    {
        $this->record = $record;

        return $this;
    }

    /**
     * Get the record to be used to generate a state.
     *
     * @return array<string, mixed>|\Illuminate\Database\Eloquent\Model|null
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * Determine if a record is set.
     *
     * @return bool
     */
    public function hasRecord()
    {
        return isset($this->record);
    }
}
