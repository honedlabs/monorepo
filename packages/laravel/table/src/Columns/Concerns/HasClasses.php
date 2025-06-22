<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

use Honed\Infolist\Entries\Concerns\HasClasses as HasHeadingClasses;

trait HasClasses
{
    use HasHeadingClasses;

    /**
     * The classes to apply to the record (row).
     *
     * @var array<int, string|Closure(mixed...):string>
     */
    protected $recordClasses = [];

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