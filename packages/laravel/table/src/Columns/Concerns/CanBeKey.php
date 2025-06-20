<?php

namespace Honed\Table\Columns\Concerns;

trait CanBeKey
{
    /**
     * Whether the column is a key.
     *
     * @var bool
     */
    protected $isKey = false;

    /**
     * Set the column to be a key.
     *
     * @param  bool  $isKey
     * @return $this
     */
    public function key($isKey = true)
    {
        $this->isKey = $isKey;

        return $this;
    }

    /**
     * Whether the column is a key.
     *
     * @return bool
     */
    public function isKey()
    {
        return $this->isKey;
    }
}