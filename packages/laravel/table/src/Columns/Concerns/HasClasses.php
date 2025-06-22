<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

use Honed\Infolist\Entries\Concerns\HasClasses as HasHeadingClasses;

trait HasClasses
{
    use HasHeadingClasses;

    /**
     * The classes to apply to an individual cell.
     *
     * @var array<int, string|Closure(mixed...):string>
     */
    protected $cellClasses = [];

    /**
     * The classes to apply to the record (row).
     *
     * @var array<int, string|Closure(mixed...):string>
     */
    protected $recordClasses = [];

    /**
     * Set the classes to apply to an individual cell.
     *
     * @param  string|Closure(mixed...):string  $classes
     * @return $this
     */
    public function cellClasses($classes)
    {
        $this->cellClasses[] = $classes;

        return $this;
    }

    /**
     * Get the classes to apply to an individual cell.
     *
     * @return string|null
     */
    public function getCellClasses()
    {
        if (empty($this->cellClasses)) {
            return null;
        }

        return implode(
            ' ',
            array_map($this->evaluate(...), $this->cellClasses)
        );
    }

    /**
     * Set the classes to apply to the record (row).
     *
     * @param  string|Closure(mixed...):string  $classes
     * @return $this
     */
    public function recordClasses($classes)
    {
        $this->classes[] = $classes;

        return $this;
    }

    /**
     * Get the classes to apply to the record (row).
     *
     * @return string|null
     */
    public function getRecordClasses()
    {
        if (empty($this->classes)) {
            return null;
        }

        return implode(
            ' ',
            array_map($this->evaluate(...), $this->classes)
        );
    }
}
