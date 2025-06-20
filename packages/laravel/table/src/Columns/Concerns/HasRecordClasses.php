<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

trait HasClasses
{
    /**
     * The classes to apply to the column itself.
     * 
     * @var string|\Closure|null
     */
    protected $classes;

    /**
     * The classes to apply to the record.
     *
     * @var string|\Closure|null
     */
    protected $recordClasses;

    /**
     * Set the classes to apply to the column itself.
     * 
     * @param string|\Closure $classes
     * @return $this
     */
    public function classes($classes)
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * Get the classes to apply to the column itself.
     * 
     * @return string|null
     */
    public function getClasses()
    {
        return $this->evaluate($this->classes);
    }

    /**
     * Set the classes to apply to the record.
     * 
     * @param string|\Closure $classes
     * @return $this
     */
    public function recordClasses($classes)
    {
        $this->recordClasses = $classes;
    }

    /**
     * Get the classes to apply to the record.
     * 
     * @return string|null
     */
    public function getRecordClasses()
    {
        return $this->evaluate($this->recordClasses);
    }
}