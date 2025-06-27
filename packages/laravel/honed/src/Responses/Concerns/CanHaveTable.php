<?php

declare(strict_types=1);

namespace Honed\Honed\Responses\Concerns;

trait CanHaveTable
{
    /**
     * The table to be rendered.
     * 
     * @var \Honed\Table\Table|null
     */
    protected $table;

    /**
     * Set the table for the response.
     * 
     * @param \Honed\Table\Table $table
     * 
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get the table to be rendered.
     * 
     * @return \Honed\Table\Table|null
     */
    public function getTable()
    {
        return $this->table;
    }    
}