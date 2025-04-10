<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Str;

trait HasLabel
{
    /**
     * The label.
     *
     * @var string|\Closure(...mixed):string|null
     */
    protected $label;

    /**
     * Set the label.
     *
     * @param  string|\Closure(...mixed):string|null  $label
     * @return $this
     */
    public function label($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the label.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return string|null
     */
    public function getLabel($parameters = [], $typed = [])
    {
        return $this->evaluate($this->label, $parameters, $typed);
    }

    /**
     * Determine if a label is set.
     *
     * @return bool
     */
    public function hasLabel()
    {
        return isset($this->label);
    }

    /**
     * Convert a string to the label format.
     *
     * @param  string|null  $name
     * @return string|null
     */
    public static function makeLabel($name)
    {
        if (! \is_string($name)) {
            return null;
        }

        return Str::of($name)
            ->afterLast('.')
            ->headline()
            ->lower()
            ->ucfirst()
            ->toString();
    }
}
