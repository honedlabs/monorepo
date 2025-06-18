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
        if (empty($this->classes)) {
            return null;
        }

        return implode(
            ' ',
            array_map($this->evaluate(...), $this->classes)
        );
    }
}
