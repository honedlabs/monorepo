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
     * @param  array<string, mixed>  $named
     * @param  array<class-string, mixed>  $typed
     * @return string|null
     */
    public function getClasses($named = [], $typed = [])
    {
        return $this->createClasses($this->classes, $named, $typed);
    }

    /**
     * Create a class from a string or closure.
     *
     * @param  array<int, string|Closure(mixed...):string>  $classes
     * @param  array<string, mixed>  $named
     * @param  array<class-string, mixed>  $typed
     * @return string|null
     */
    protected function createClasses($classes, $named = [], $typed = [])
    {
        if (empty($classes)) {
            return null;
        }

        /** @var string */
        $classes = implode(' ', array_map(
            fn ($value) => $this->evaluate($value, $named, $typed),
            $classes)
        );

        return $classes === '' ? null : $classes;
    }
}
