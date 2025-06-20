<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

trait HasPlaceholder
{
    /**
     * The placeholder value to be used for the column.
     * 
     * @var mixed
     */
    protected $placeholder;

    /**
     * Set the placeholder value to be used for the column.
     * 
     * @param mixed $placeholder
     * @return $this
     */
    public function placeholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the placeholder value to be used for the column.
     * 
     * @return mixed
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }
}