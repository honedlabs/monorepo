<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Str;

use function is_string;

trait HasLabel
{
    /**
     * The label.
     *
     * @var string|(\Closure(...mixed):string)|null
     */
    protected $label;

    /**
     * Convert a string to the label format.
     *
     * @param  string|null  $name
     * @return string|null
     */
    public static function makeLabel($name)
    {
        if (! is_string($name)) {
            return null;
        }

        return Str::of($name)
            ->afterLast('.')
            ->headline()
            ->lower()
            ->ucfirst()
            ->toString();
    }

    /**
     * Set the label.
     *
     * @param  string|(\Closure(...mixed):string)|null  $label
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
     * @return string|null
     */
    public function getLabel()
    {
        return $this->evaluate($this->label);
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
}
