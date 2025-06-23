<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Closure;

trait HasClasses
{
    /**
     * The classes to apply to the entry.
     *
     * @var array<int, string|Closure(mixed...):string>
     */
    protected $classes = [];

    /**
     * Set the classes to apply to the entry.
     *
     * @param  string|Closure(mixed...):string  $classes
     * @return $this
     */
    public function classes($classes)
    {
        $this->classes[] = $classes;

        return $this;
    }

    /**
     * Get the classes to apply to the entry.
     *
     * @return string|null
     */
    public function getClasses()
    {
        return $this->createClass($this->classes);
    }

    /**
     * Create a class from a string or closure.
     *
     * @param  array<int, string|Closure(mixed...):string>  $classes
     * @return string|null
     */
    protected function createClass($classes)
    {
        if (empty($classes)) {
            return null;
        }

        /** @var string */
        $classes = implode(' ', array_map($this->evaluate(...), $classes));

        return $classes === '' ? null : $classes;
    }
}
